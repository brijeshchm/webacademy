<?php

namespace App\Http\Controllers\Web;

use App\Data\DoctorateCards;
use App\Data\DoctorateProgrammes;
use App\Data\Faqs;
use App\Data\PartnerUniversities;
use App\Http\Controllers\Controller;
use App\Services\ServerTranslator;
use Illuminate\View\View;

/**
 * Server-rendered DBA / doctorate pages ported from the React
 * Doctorate.tsx, DoctorateDetail.tsx, and UniversityDetail.tsx pages.
 *
 * Static content comes from app/Data/* (ported verbatim from the React
 * src/data/*.ts and src/lib/universities.ts). Displayed free-text is run
 * through ServerTranslator for non-English locales (proper names stay English).
 */
class DoctorateController extends Controller
{
    /** GET /doctorate */
    public function index(): View
    {
        $cards = DoctorateCards::all();
        $universities = PartnerUniversities::all();

        // ── Batch-translate ALL dynamic strings in ONE query ───────────
        // Collect every card title + highlight and every partner-university
        // blurb, resolve via a single translateMany(), and hand the view a
        // lookup closure ($tDyn). The Blade template does array lookups only
        // — no ServerTranslator calls.
        $allStrings = array_map(static fn (array $c): string => $c['title'], $cards);
        foreach ($cards as $c) {
            foreach ($c['highlights'] as $h) {
                $allStrings[] = $h;
            }
        }
        foreach ($universities as $u) {
            $allStrings[] = $u['blurb'];
        }

        $tDyn = self::lookupClosure($allStrings);

        return view('pages.doctorate', [
            'cards' => $cards,
            'universities' => $universities,
            'programmeTitles' => array_map(
                static fn (array $c): string => $c['title'],
                $cards
            ),
            'faqs' => Faqs::DOCTORATE,
            'tDyn' => $tDyn,
        ]);
    }

    /** GET /doctorate/{slug} */
    public function show(string $slug): View
    {
        $prog = DoctorateProgrammes::find($slug);
        abort_if($prog === null, 404);

        // Collect EVERY dynamic string from the programme (description,
        // outcomes, eligibility, curriculum titles + topics, career roles,
        // faculty titles + tags, faq q/a, sample reviews, title/tagline) and
        // resolve the whole set through a single translateMany() query. The
        // view then does array lookups via $tDyn.
        $sampleReviews = array_column(DoctorateProgrammes::SAMPLE_REVIEWS, 'review');

        $allStrings = array_merge(
            [$prog['title'], $prog['tagline']],
            $prog['description'],
            $prog['outcomes'],
            $prog['eligibility'],
            array_map(static fn ($p) => $p['title'], $prog['curriculum']),
            array_map(static fn ($r) => $r['role'], $prog['careerRoles']),
            array_map(static fn ($f) => $f['title'], $prog['faculty']),
            array_map(static fn ($f) => $f['q'], $prog['faq']),
            array_map(static fn ($f) => $f['a'], $prog['faq']),
            $sampleReviews,
        );
        foreach ($prog['curriculum'] as $phase) {
            foreach ($phase['topics'] as $topic) {
                $allStrings[] = $topic;
            }
        }
        foreach ($prog['faculty'] as $f) {
            foreach ($f['tags'] as $tag) {
                $allStrings[] = $tag;
            }
        }

        $tDyn = self::lookupClosure($allStrings);

        return view('pages.doctorate-detail', [
            'prog' => $prog,
            'university' => PartnerUniversities::findByShortName($prog['university']),
            'tDyn' => $tDyn,
        ]);
    }

    /** GET /universities/{slug} */
    public function university(string $slug): View
    {
        $uni = PartnerUniversities::findBySlug($slug);
        abort_if($uni === null, 404);

        // Collect the free-text fields (about paragraphs, highlights, stat
        // labels, university type) and resolve them in ONE translateMany()
        // query; the view looks them up via $tDyn.
        $allStrings = array_merge(
            $uni['about'],
            $uni['highlights'],
            array_map(static fn ($s) => $s['label'], $uni['stats']),
            [$uni['type']],
        );

        $tDyn = self::lookupClosure($allStrings);

        return view('pages.university-detail', [
            'uni' => $uni,
            'tDyn' => $tDyn,
        ]);
    }

    /**
     * Resolve the given strings through a single cache-only translateMany()
     * query and return a closure that maps any original string to its
     * translation (falling back to the original when absent).
     *
     * @param  array<int,?string>  $strings
     * @return \Closure(?string):?string
     */
    private static function lookupClosure(array $strings): \Closure
    {
        $map = [];
        $translated = ServerTranslator::translateMany($strings);
        foreach ($strings as $i => $original) {
            if (is_string($original) && $original !== '') {
                $map[$original] = $translated[$i] ?? $original;
            }
        }

        return static fn (?string $v): ?string => ($v !== null && isset($map[$v])) ? $map[$v] : $v;
    }

    /**
     * Organization + EducationalOrganization JSON-LD — mirrors
     * PageSEO.tsx buildOrganizationJsonLd().
     *
     * @return array<string, mixed>
     */
    public static function organizationJsonLd(): array
    {
        $origin = rtrim((string) config('services.site.origin'), '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'EducationalOrganization'],
            '@id' => $origin . '/#organization',
            'name' => 'Corporate Academy',
            'url' => $origin,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $origin . '/favicon.svg',
                'width' => 200,
                'height' => 200,
            ],
            'image' => $origin . '/api/og-image',
            'description' => 'Corporate Academy is a professional technology training and certification institute offering 490+ courses across IT, business, and management. 63,000+ professionals trained with globally recognized certifications.',
            'foundingDate' => '2018',
            'areaServed' => ['@type' => 'Country', 'name' => 'India'],
            'contactPoint' => [[
                '@type' => 'ContactPoint',
                'telephone' => '+91-88001-82225',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Hindi'],
            ]],
            'sameAs' => [],
            'offers' => [
                '@type' => 'AggregateOffer',
                'offerCount' => '490',
                'priceCurrency' => 'INR',
            ],
        ];
    }

    /**
     * FAQPage JSON-LD — mirrors PageSEO.tsx buildFAQJsonLd().
     *
     * @param  array<int, array{question: string, answer: string}>  $faqs
     * @return array<string, mixed>
     */
    public static function faqJsonLd(array $faqs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $f): array => [
                '@type' => 'Question',
                'name' => $f['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $f['answer'],
                ],
            ], $faqs),
        ];
    }

    /**
     * BreadcrumbList JSON-LD — mirrors PageSEO.tsx buildBreadcrumbJsonLd().
     *
     * @param  array<int, array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    public static function breadcrumbJsonLd(array $items): array
    {
        $list = [];
        foreach ($items as $i => $item) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }

    /**
     * Translate one string via the render-time cache-only translator.
     */
    public static function tr(?string $text): ?string
    {
        return ServerTranslator::translate($text);
    }
}
