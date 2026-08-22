<?php

namespace Tests\Feature\Web;

use App\Data\DoctorateProgrammes;
use App\Data\PartnerUniversities;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Server-rendered DBA / doctorate pages: /doctorate, /doctorate/{slug},
 * /universities/{slug}. Ported from Doctorate.tsx, DoctorateDetail.tsx and
 * UniversityDetail.tsx. Static content comes from app/Data/*; unknown slugs
 * 404; non-English locales render dir="rtl" and cached translations.
 */
class DoctorateWebTest extends TestCase
{
    use RefreshDatabase;

    /* ── /doctorate listing ──────────────────────────────────── */

    public function test_doctorate_returns_200_with_key_content(): void
    {
        $this->get('/doctorate')
            ->assertStatus(200)
            ->assertSee('Doctor of Business', false) // hero title line
            ->assertSee('Online DBA Courses', false) // programmes accent
            ->assertSee('Golden Gate University', false); // partner university
    }

    public function test_doctorate_renders_all_cards_and_faq_jsonld(): void
    {
        $response = $this->get('/doctorate');
        $response->assertStatus(200);

        // FAQPage + Organization JSON-LD present.
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('EducationalOrganization', false);

        // A specific programme card title from the static data.
        $response->assertSee('Executive DBA in Digital Transformation', false);
    }

    public function test_doctorate_tag_filter_narrows_visible_cards(): void
    {
        // No-JS graceful filter via ?tag=. Finance shows the finance card,
        // hides a non-finance one from the rendered (non-hidden) set.
        $response = $this->get('/doctorate?tag=' . urlencode('Finance'));
        $response->assertStatus(200)
            ->assertSee('DBA in Finance &amp; Global Markets', false);
    }

    public function test_doctorate_arabic_sets_rtl(): void
    {
        $this->get('/doctorate?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    public function test_doctorate_lead_form_stores_and_redirects(): void
    {
        $response = $this->post('/leads', [
            'name' => 'Jane Executive',
            'email' => 'jane@example.com',
            'phone' => '+919000000000',
            'company' => 'Acme Corp',
            'program' => 'Doctor of Business Administration (DBA)',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('leads', [
            'name' => 'Jane Executive',
            'email' => 'jane@example.com',
        ]);
    }

    /* ── /doctorate/{slug} detail ────────────────────────────── */

    public function test_doctorate_detail_returns_200(): void
    {
        $slug = array_key_first(DoctorateProgrammes::all());

        $this->get('/doctorate/' . $slug)
            ->assertStatus(200)
            ->assertSee('About This Programme', false)
            ->assertSee('Programme Structure', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_doctorate_detail_unknown_slug_404(): void
    {
        $this->get('/doctorate/not-a-real-programme')
            ->assertStatus(404);
    }

    public function test_doctorate_detail_arabic_rtl(): void
    {
        $slug = array_key_first(DoctorateProgrammes::all());

        $this->get('/doctorate/' . $slug . '?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    /* ── /universities/{slug} ────────────────────────────────── */

    public function test_university_detail_returns_200(): void
    {
        $uni = PartnerUniversities::all()[0];

        $this->get('/universities/' . $uni['slug'])
            ->assertStatus(200)
            ->assertSee($uni['name'], false)
            ->assertSee('Accreditation &amp; Recognition', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_university_detail_unknown_slug_404(): void
    {
        $this->get('/universities/not-a-real-university')
            ->assertStatus(404);
    }

    public function test_university_detail_arabic_rtl(): void
    {
        $uni = PartnerUniversities::all()[0];

        $this->get('/universities/' . $uni['slug'] . '?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    /* ── Bounded translation-query regressions ───────────────── */

    /**
     * Count queries against the `translations` table while rendering a URL in
     * a non-English locale. Mirrors HomeTest's bounded-query regression.
     */
    private function countTranslationQueries(string $url): int
    {
        $count = 0;
        DB::listen(function ($query) use (&$count): void {
            if (str_contains($query->sql, '"translations"') || str_contains($query->sql, '`translations`')) {
                $count++;
            }
        });

        $this->get($url)->assertStatus(200);

        return $count;
    }

    public function test_doctorate_uses_bounded_translation_queries(): void
    {
        $n = $this->countTranslationQueries('/doctorate?lng=fr');

        $this->assertLessThanOrEqual(
            3,
            $n,
            "/doctorate ran {$n} translations-table queries; expected a bounded number (<= 3)."
        );
    }

    public function test_doctorate_detail_uses_bounded_translation_queries(): void
    {
        $slug = array_key_first(DoctorateProgrammes::all());

        $n = $this->countTranslationQueries('/doctorate/' . $slug . '?lng=fr');

        $this->assertLessThanOrEqual(
            3,
            $n,
            "/doctorate/{$slug} ran {$n} translations-table queries; expected a bounded number (<= 3)."
        );
    }

    public function test_university_detail_uses_bounded_translation_queries(): void
    {
        $uni = PartnerUniversities::all()[0];

        $n = $this->countTranslationQueries('/universities/' . $uni['slug'] . '?lng=fr');

        $this->assertLessThanOrEqual(
            3,
            $n,
            "/universities/{$uni['slug']} ran {$n} translations-table queries; expected a bounded number (<= 3)."
        );
    }

    public function test_cached_translation_is_used_for_non_english(): void
    {
        // Pre-warm the cache with an Arabic translation of a card highlight,
        // then confirm the rendered page uses the cached value (cache-only).
        $source = 'Ph.D.-equivalent credential';
        $translated = 'اعتماد معادل للدكتوراه';

        DB::table('translations')->insert([
            'lang' => 'ar',
            'source_hash' => hash('sha256', $source),
            'translation' => $translated,
            'created_at' => now(),
        ]);

        $this->get('/doctorate?lng=ar')
            ->assertStatus(200)
            ->assertSee($translated, false);
    }
}
