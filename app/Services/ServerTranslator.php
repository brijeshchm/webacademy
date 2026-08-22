<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Cache-only translation of dynamic DB/static text for server-rendered pages.
 *
 * Mirrors TranslateController's cache scheme: the `translations` table is
 * keyed by (lang, sha256(source text)). On a page render we NEVER call the
 * LLM — a cache miss falls back to the English original. English locale is a
 * pass-through. Supported non-English locales match SetLocale::SUPPORTED.
 */
class ServerTranslator
{
    private const LANGS = ['hi', 'zh', 'fr', 'es', 'de', 'ru', 'ar'];

    /**
     * Translate a single string to the active locale (cache-only).
     */
    public static function translate(?string $text): ?string
    {
        if ($text === null || $text === '') {
            return $text;
        }

        $lang = App::getLocale();
        if (!in_array($lang, self::LANGS, true)) {
            return $text;
        }

        $hash = hash('sha256', $text);
       /* $row = DB::table('translations')
            ->where('lang', $lang)
            ->where('source_hash', $hash)
            ->value('translation');*/
			$row="";
        return is_string($row) && $row !== '' ? $row : $text;
    }

    /**
     * Translate many strings in one query (cache-only), preserving order.
     *
     * @param  array<int,?string>  $texts
     * @return array<int,?string>
     */
    public static function translateMany(array $texts): array
    {
        $lang = App::getLocale();
        if (!in_array($lang, self::LANGS, true)) {
            return $texts;
        }

        // Build hash lookup only for non-empty strings.
        $hashes = [];
        foreach ($texts as $i => $text) {
            if (is_string($text) && $text !== '') {
                $hashes[$i] = hash('sha256', $text);
            }
        }

        if (empty($hashes)) {
            return $texts;
        }

        $rows = DB::table('translations')
            ->where('lang', $lang)
            ->whereIn('source_hash', array_values(array_unique($hashes)))
            ->get(['source_hash', 'translation']);

        $byHash = [];
        foreach ($rows as $row) {
            $byHash[$row->source_hash] = $row->translation;
        }

        $out = $texts;
        foreach ($hashes as $i => $hash) {
            if (isset($byHash[$hash]) && $byHash[$hash] !== '') {
                $out[$i] = $byHash[$hash];
            }
        }

        return $out;
    }
}
