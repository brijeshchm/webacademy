<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\TranslationBudget;

/**
 * Translation endpoint backed by a persistent MySQL cache.
 *
 * Mirrors the Node API (artifacts/api-server/src/lib/translationCache.ts):
 * translations are cached in the `translations` table keyed by
 * (lang, sha256(source text)). Cache hits are served without any LLM call,
 * so pre-seeded catalog text appears instantly on first page view.
 * Misses are translated via the OpenAI-compatible API (batched with a
 * separator marker) and written back to the cache.
 */
class TranslateController extends Controller
{
    private const LANG_NAMES = [
        'hi' => 'Hindi',
        'zh' => 'Simplified Chinese',
        'fr' => 'French',
        'es' => 'Spanish',
        'de' => 'German',
        'ru' => 'Russian',
        'ar' => 'Arabic',
    ];

    private const MAX_TEXT_LENGTH = 3000;
    private const MAX_BATCH_ITEMS = 100;
    // Aggregate per-request cap, matching the Node API.
    private const MAX_BATCH_TOTAL_CHARS = 20000;
    // Segment separator for packing several strings into one LLM call.
    private const SEP = '<<<SEP>>>';
    // How many strings to pack per LLM call when filling cache misses.
    private const LLM_BATCH_SIZE = 20;

    public function __construct(private TranslationBudget $budget)
    {
    }

    public function translate(Request $request): JsonResponse
    {
        $text       = $request->input('text');
        $targetLang = $request->input('targetLang') ?? $request->input('targetLocale');

        if (!is_string($text) || !trim($text)) {
            return response()->json(['error' => 'text is required.'], 400);
        }
        if (!is_string($targetLang) || !isset(self::LANG_NAMES[$targetLang])) {
            return response()->json(['error' => 'targetLang must be one of: hi, zh, fr, es, de, ru, ar.'], 400);
        }
        if (strlen($text) > self::MAX_TEXT_LENGTH) {
            return response()->json(['error' => 'text too long.'], 400);
        }

        try {
            $translations = $this->translateTexts([$text], $targetLang, $request->ip() ?? 'unknown');
        } catch (\RuntimeException $e) {
            return $this->translateErrorResponse($e);
        }

        return response()->json(['translation' => $translations[0]]);
    }

    public function translateBatch(Request $request): JsonResponse
    {
        $texts      = $request->input('texts');
        $targetLang = $request->input('targetLang') ?? $request->input('targetLocale');

        $invalid = !is_array($texts)
            || count($texts) === 0
            || count($texts) > self::MAX_BATCH_ITEMS;
        if (!$invalid) {
            foreach ($texts as $t) {
                if (!is_string($t) || !trim($t) || strlen($t) > self::MAX_TEXT_LENGTH) {
                    $invalid = true;
                    break;
                }
            }
        }
        if ($invalid) {
            return response()->json([
                'error' => 'texts must be 1-' . self::MAX_BATCH_ITEMS
                    . ' non-empty strings of at most ' . self::MAX_TEXT_LENGTH . ' characters.',
            ], 400);
        }

        $totalChars = array_sum(array_map('strlen', $texts));
        if ($totalChars > self::MAX_BATCH_TOTAL_CHARS) {
            return response()->json([
                'error' => 'texts must total at most ' . self::MAX_BATCH_TOTAL_CHARS . ' characters per request.',
            ], 400);
        }

        if (!is_string($targetLang) || !isset(self::LANG_NAMES[$targetLang])) {
            return response()->json(['error' => 'targetLang must be one of: hi, zh, fr, es, de, ru, ar.'], 400);
        }

        try {
            $translations = $this->translateTexts(array_values($texts), $targetLang, $request->ip() ?? 'unknown');
        } catch (\RuntimeException $e) {
            return $this->translateErrorResponse($e);
        }

        return response()->json(['translations' => $translations]);
    }

    /**
     * Translate texts into $lang, serving from the persistent cache and only
     * calling the LLM for cache misses (which are then cached). Order preserved.
     *
     * Cache misses count against per-IP and global character budgets and a
     * shared LLM concurrency cap (see TranslationBudget); when exhausted a
     * \RuntimeException('budget_exhausted' | 'llm_busy') is thrown before any
     * LLM call, and the caller responds 429. Cache hits are always served.
     *
     * @param  string[] $texts
     * @return string[]
     * @throws \RuntimeException when budgets are exhausted or the LLM call fails
     */
    private function translateTexts(array $texts, string $lang, string $clientIp): array
    {
        $hashes = array_map(fn($t) => hash('sha256', $t), $texts);

        // Cache lookup.
        $cached = [];
        $rows = DB::table('translations')
            ->where('lang', $lang)
            ->whereIn('source_hash', array_unique($hashes))
            ->get(['source_hash', 'translation']);
        foreach ($rows as $row) {
            $cached[$row->source_hash] = $row->translation;
        }

        // Unique missing source texts keyed by hash.
        $missing = [];
        foreach ($texts as $i => $text) {
            $h = $hashes[$i];
            if (!isset($cached[$h])) {
                $missing[$h] = $text;
            }
        }

        if (!empty($missing)) {
            $missChars = array_sum(array_map('strlen', $missing));
            if (!$this->budget->tryConsumeMissBudget($clientIp, $missChars)) {
                throw new \RuntimeException('budget_exhausted');
            }

            $langName = self::LANG_NAMES[$lang];
            $entries  = [];
            foreach (array_chunk($missing, self::LLM_BATCH_SIZE, true) as $chunk) {
                $chunkHashes = array_keys($chunk);
                $translated  = $this->budget->withLlmSlot(
                    fn() => $this->llmTranslateBatch(array_values($chunk), $langName)
                );
                foreach ($chunkHashes as $j => $h) {
                    $cached[$h] = $translated[$j];
                    $entries[]  = [
                        'lang'        => $lang,
                        'source_hash' => $h,
                        'translation' => $translated[$j],
                        'created_at'  => now(),
                    ];
                }
            }
            if (!empty($entries)) {
                // insertOrIgnore ≈ ON CONFLICT DO NOTHING: concurrent requests
                // caching the same text must not fail on the unique index.
                DB::table('translations')->insertOrIgnore($entries);
            }
        }

        return array_map(fn($i) => $cached[$hashes[$i]] ?? $texts[$i], array_keys($texts));
    }

    private function translateErrorResponse(\RuntimeException $e): JsonResponse
    {
        if (in_array($e->getMessage(), ['budget_exhausted', 'llm_busy'], true)) {
            return response()->json(['error' => 'Translation budget exhausted. Please try again later.'], 429);
        }

        return response()->json(['error' => 'Translation service temporarily unavailable.'], 500);
    }

    /**
     * Translate a batch of strings in one LLM call using a separator marker.
     *
     * @param  string[] $texts
     * @return string[]
     * @throws \RuntimeException
     */
    private function llmTranslateBatch(array $texts, string $langName): array
    {
        $sep    = self::SEP;
        $joined = implode("\n{$sep}\n", $texts);

        $openaiBaseUrl = rtrim(env('OPENAI_BASE_URL', 'https://api.openai.com/v1'), '/');
        $openaiApiKey  = env('OPENAI_API_KEY', '');

        try {
            $response = Http::withHeaders([
            'Authorization' => "Bearer {$openaiApiKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(60)->post("{$openaiBaseUrl}/chat/completions", [
            'model'                 => 'gpt-5.4-mini',
            'max_completion_tokens' => 8192,
            'messages'              => [
                [
                    'role'    => 'system',
                    'content' => "You are a professional translator. Translate the user's text into {$langName}. "
                        . "The input contains one or more segments separated by the marker {$sep} on its own line. "
                        . "Translate each segment independently and return the translations in the same order, "
                        . "separated by the same {$sep} marker on its own line. "
                        . 'Return only the translated text with no explanations, no quotes, and no extra formatting.',
                ],
                ['role' => 'user', 'content' => $joined],
            ],
        ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::warning('Translation LLM connection failed', ['error' => $e->getMessage()]);
            throw new \RuntimeException('LLM call failed', 0, $e);
        }

        if (!$response->successful()) {
            Log::warning('Translation LLM call failed', ['status' => $response->status()]);
            throw new \RuntimeException('LLM call failed');
        }

        $raw   = $response->json('choices.0.message.content') ?? '';
        $parts = preg_split('/\n?' . preg_quote($sep, '/') . '\n?/', $raw);

        return array_map(
            fn($i) => isset($parts[$i]) && trim($parts[$i]) !== '' ? trim($parts[$i]) : $texts[$i],
            array_keys($texts),
        );
    }
}
