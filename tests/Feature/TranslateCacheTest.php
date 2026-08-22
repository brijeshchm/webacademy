<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TranslateCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_cache_hit_serves_without_llm_call(): void
    {
        Http::fake(); // any HTTP call would fail the assertion below

        DB::table('translations')->insert([
            'lang'        => 'hi',
            'source_hash' => hash('sha256', 'Hello world'),
            'translation' => 'नमस्ते दुनिया',
            'created_at'  => now(),
        ]);

        $res = $this->postJson('/api/translate', [
            'text'       => 'Hello world',
            'targetLang' => 'hi',
        ]);

        $res->assertOk()->assertJson(['translation' => 'नमस्ते दुनिया']);
        Http::assertNothingSent();
    }

    public function test_cache_miss_calls_llm_and_stores_result(): void
    {
        Http::fake([
            '*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Bonjour le monde']],
                ],
            ]),
        ]);

        $res = $this->postJson('/api/translate', [
            'text'       => 'Hello world',
            'targetLang' => 'fr',
        ]);

        $res->assertOk()->assertJson(['translation' => 'Bonjour le monde']);
        $this->assertDatabaseHas('translations', [
            'lang'        => 'fr',
            'source_hash' => hash('sha256', 'Hello world'),
            'translation' => 'Bonjour le monde',
        ]);

        // Second identical request is a cache hit — no further HTTP calls.
        Http::fake();
        $this->postJson('/api/translate', [
            'text'       => 'Hello world',
            'targetLang' => 'fr',
        ])->assertOk()->assertJson(['translation' => 'Bonjour le monde']);
        Http::assertNothingSent();
    }

    public function test_batch_mixes_cache_hits_and_llm_misses(): void
    {
        DB::table('translations')->insert([
            'lang'        => 'es',
            'source_hash' => hash('sha256', 'Cached text'),
            'translation' => 'Texto en caché',
            'created_at'  => now(),
        ]);

        Http::fake([
            '*' => Http::response([
                'choices' => [
                    ['message' => ['content' => "Texto nuevo"]],
                ],
            ]),
        ]);

        $res = $this->postJson('/api/translate/batch', [
            'texts'      => ['Cached text', 'New text'],
            'targetLang' => 'es',
        ]);

        $res->assertOk()->assertJson([
            'translations' => ['Texto en caché', 'Texto nuevo'],
        ]);
        Http::assertSentCount(1);
        $this->assertDatabaseHas('translations', [
            'lang'        => 'es',
            'source_hash' => hash('sha256', 'New text'),
        ]);
    }

    public function test_budget_exhaustion_returns_429_without_llm_call(): void
    {
        Http::fake(); // any HTTP call would fail the assertion below

        // Exhaust this client's per-IP cache-miss budget.
        $budget = app(\App\Services\TranslationBudget::class);
        $this->assertTrue($budget->tryConsumeMissBudget(
            '127.0.0.1',
            \App\Services\TranslationBudget::PER_IP_MISS_CHAR_BUDGET,
        ));

        $this->postJson('/api/translate', [
            'text'       => 'Novel uncached text',
            'targetLang' => 'hi',
        ])->assertStatus(429);

        Http::assertNothingSent();
        $this->assertDatabaseMissing('translations', [
            'source_hash' => hash('sha256', 'Novel uncached text'),
        ]);
    }

    public function test_cache_hits_are_served_even_when_budget_exhausted(): void
    {
        Http::fake();

        DB::table('translations')->insert([
            'lang'        => 'hi',
            'source_hash' => hash('sha256', 'Cached greeting'),
            'translation' => 'नमस्कार',
            'created_at'  => now(),
        ]);

        $budget = app(\App\Services\TranslationBudget::class);
        $budget->tryConsumeMissBudget(
            '127.0.0.1',
            \App\Services\TranslationBudget::PER_IP_MISS_CHAR_BUDGET,
        );

        $this->postJson('/api/translate', [
            'text'       => 'Cached greeting',
            'targetLang' => 'hi',
        ])->assertOk()->assertJson(['translation' => 'नमस्कार']);
        Http::assertNothingSent();
    }

    public function test_global_budget_circuit_breaker(): void
    {
        Http::fake();

        $budget = app(\App\Services\TranslationBudget::class);
        // Other IPs together consume the whole global budget (each stays
        // within its own per-IP budget).
        $perIp = \App\Services\TranslationBudget::PER_IP_MISS_CHAR_BUDGET;
        $remaining = \App\Services\TranslationBudget::GLOBAL_MISS_CHAR_BUDGET;
        for ($i = 1; $remaining > 0; $i++) {
            $chunk = min($perIp, $remaining);
            $this->assertTrue($budget->tryConsumeMissBudget("10.0.0.{$i}", $chunk));
            $remaining -= $chunk;
        }

        // This client has untouched per-IP budget but is still refused.
        $this->postJson('/api/translate', [
            'text'       => 'Another novel text',
            'targetLang' => 'fr',
        ])->assertStatus(429);
        Http::assertNothingSent();
    }

    public function test_llm_slot_rejects_when_all_slots_busy(): void
    {
        $budget = app(\App\Services\TranslationBudget::class);

        // Simulate MAX_CONCURRENT_LLM_CALLS in-flight calls by pinning the
        // shared slot counter at the cap.
        \Illuminate\Support\Facades\Cache::put(
            'translate:llm_active',
            \App\Services\TranslationBudget::MAX_CONCURRENT_LLM_CALLS,
            120,
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('llm_busy');
        $budget->withLlmSlot(fn() => 'should not run');
    }

    public function test_batch_validation(): void
    {
        $this->postJson('/api/translate/batch', [
            'texts'      => [],
            'targetLang' => 'hi',
        ])->assertStatus(400);

        $this->postJson('/api/translate/batch', [
            'texts'      => ['ok'],
            'targetLang' => 'xx',
        ])->assertStatus(400);

        $this->postJson('/api/translate/batch', [
            'texts'      => [str_repeat('a', 3001)],
            'targetLang' => 'hi',
        ])->assertStatus(400);
    }
}
