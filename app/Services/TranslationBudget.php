<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Cost guards for the public translation endpoints.
 *
 * The persistent cache makes cache HITS cheap, but attacker-supplied novel
 * text is always a cache MISS that triggers a paid LLM call. These budgets
 * bound how many characters of cache-miss text can reach the LLM:
 *  - per client IP per hour (stops a single abuser), and
 *  - globally per minute (circuit breaker so many IPs can't exhaust the
 *    provider quota together).
 * A shared concurrency cap additionally stops concurrent misses from
 * stampeding the upstream provider. State lives in the Laravel cache so it
 * is shared across PHP-FPM workers.
 */
class TranslationBudget
{
    // Per-IP: 60k chars of cache-miss text per hour is far above any
    // legitimate first-visit page load (a full catalog page is a few
    // thousand chars).
    public const PER_IP_MISS_CHAR_BUDGET = 60000;
    public const PER_IP_WINDOW_SECONDS = 3600;

    // Global circuit breaker: 120k chars of public cache-miss text per minute.
    public const GLOBAL_MISS_CHAR_BUDGET = 120000;
    public const GLOBAL_WINDOW_SECONDS = 60;

    // At most this many LLM calls in flight across all workers.
    public const MAX_CONCURRENT_LLM_CALLS = 4;
    private const SLOT_KEY = 'translate:llm_active';
    // Safety TTL so a crashed worker can't leak a slot forever.
    private const SLOT_TTL_SECONDS = 120;
    private const SLOT_WAIT_ATTEMPTS = 25;   // ~5s total at 200ms per attempt
    private const SLOT_WAIT_MICROSECONDS = 200000;

    /**
     * Try to reserve $missChars characters of LLM work for $ip.
     * Returns false when either the per-IP or the global budget is
     * exhausted; in that case no budget is consumed and the caller
     * should respond 429.
     */
    public function tryConsumeMissBudget(string $ip, int $missChars): bool
    {
        if ($missChars <= 0) {
            return true;
        }

        $ipKey     = 'translate:budget:ip:' . sha1($ip);
        $globalKey = 'translate:budget:global';

        // Check both before consuming either, so a global refusal doesn't
        // burn the client's per-IP budget (and vice versa).
        $ipUsed     = (int) Cache::get($ipKey, 0);
        $globalUsed = (int) Cache::get($globalKey, 0);
        if ($ipUsed + $missChars > self::PER_IP_MISS_CHAR_BUDGET
            || $globalUsed + $missChars > self::GLOBAL_MISS_CHAR_BUDGET) {
            return false;
        }

        // add() sets the TTL only when the key is new, so the window is
        // anchored to the first miss in the window.
        Cache::add($ipKey, 0, self::PER_IP_WINDOW_SECONDS);
        Cache::increment($ipKey, $missChars);
        Cache::add($globalKey, 0, self::GLOBAL_WINDOW_SECONDS);
        Cache::increment($globalKey, $missChars);

        return true;
    }

    /**
     * Run $fn while holding one of the shared LLM concurrency slots.
     * Waits briefly for a slot; throws \RuntimeException('llm_busy')
     * if none frees up, so the caller can respond 429.
     *
     * @template T
     * @param  callable():T $fn
     * @return T
     */
    public function withLlmSlot(callable $fn)
    {
        $acquired = false;
        for ($attempt = 0; $attempt < self::SLOT_WAIT_ATTEMPTS; $attempt++) {
            Cache::add(self::SLOT_KEY, 0, self::SLOT_TTL_SECONDS);
            $active = (int) Cache::increment(self::SLOT_KEY);
            if ($active <= self::MAX_CONCURRENT_LLM_CALLS) {
                $acquired = true;
                break;
            }
            Cache::decrement(self::SLOT_KEY);
            usleep(self::SLOT_WAIT_MICROSECONDS);
        }
        if (!$acquired) {
            throw new \RuntimeException('llm_busy');
        }

        try {
            return $fn();
        } finally {
            Cache::decrement(self::SLOT_KEY);
        }
    }
}
