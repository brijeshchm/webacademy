<?php
/**
 * Dumps (as a JSON array on stdout) every STATIC English string that the
 * server-rendered Blade site passes through App\Services\ServerTranslator at
 * render time. Mirrors, section by section, the string collection done in:
 *
 *   - DoctorateController::index()      (card titles + highlights, uni blurbs)
 *   - DoctorateController::show()       (programme detail fields + sample reviews)
 *   - DoctorateController::university() (about, highlights, stat labels, type)
 *   - HomeController::__invoke()        (Faqs::HOME q/a)
 *   - CoursesController::index()        (Faqs::COURSES q/a)
 *
 * All other Faqs constants are included too, so future Blade pages that
 * translate them are already protected. Dynamic DB text (courses, categories,
 * testimonials) is protected separately by the API server's live catalog set.
 *
 * Consumed by scripts/generate-static-texts-snapshot.mjs, which unions these
 * strings into the STATIC_FRONTEND_TEXTS snapshot so the translation-cache
 * cleanup never prunes (and re-purchases) their cached translations —
 * ServerTranslator is cache-only, so a pruned row silently reverts that text
 * to English on the live PHP site.
 *
 * Standalone PHP — no Laravel bootstrap required (app/Data is framework-free).
 * Usage: php laravel-backend/scripts/dump-server-translated-texts.php
 */

declare(strict_types=1);

error_reporting(E_ALL);

$dataDir = dirname(__DIR__) . '/app/Data';
foreach (['Faqs', 'DoctorateCards', 'DoctorateProgrammes', 'PartnerUniversities'] as $class) {
    require_once $dataDir . '/' . $class . '.php';
}

use App\Data\DoctorateCards;
use App\Data\DoctorateProgrammes;
use App\Data\Faqs;
use App\Data\PartnerUniversities;

/** @var array<string, list<string>> $sections */
$sections = [];

$push = function (string $section, $value) use (&$sections): void {
    if (is_string($value) && trim($value) !== '') {
        $sections[$section][] = $value;
    }
};

// ── PartnerUniversities (DoctorateController::index + ::university) ────────
foreach (PartnerUniversities::all() as $u) {
    $push('universities', $u['blurb'] ?? null);
    $push('universities', $u['type'] ?? null);
    foreach ($u['about'] ?? [] as $p) {
        $push('universities', $p);
    }
    foreach ($u['highlights'] ?? [] as $h) {
        $push('universities', $h);
    }
    foreach ($u['stats'] ?? [] as $s) {
        $push('universities', $s['label'] ?? null);
    }
}

// ── DoctorateCards (DoctorateController::index) ─────────────────────────────
foreach (DoctorateCards::all() as $c) {
    $push('cards', $c['title'] ?? null);
    foreach ($c['highlights'] ?? [] as $h) {
        $push('cards', $h);
    }
}

// ── DoctorateProgrammes (DoctorateController::show) ─────────────────────────
foreach (DoctorateProgrammes::all() as $prog) {
    $push('programmes', $prog['title'] ?? null);
    $push('programmes', $prog['tagline'] ?? null);
    foreach (array_merge($prog['description'] ?? [], $prog['outcomes'] ?? [], $prog['eligibility'] ?? []) as $s) {
        $push('programmes', $s);
    }
    foreach ($prog['curriculum'] ?? [] as $phase) {
        $push('programmes', $phase['title'] ?? null);
        foreach ($phase['topics'] ?? [] as $topic) {
            $push('programmes', $topic);
        }
    }
    foreach ($prog['careerRoles'] ?? [] as $r) {
        $push('programmes', $r['role'] ?? null);
    }
    foreach ($prog['faculty'] ?? [] as $f) {
        $push('programmes', $f['title'] ?? null);
        foreach ($f['tags'] ?? [] as $tag) {
            $push('programmes', $tag);
        }
    }
    foreach ($prog['faq'] ?? [] as $f) {
        $push('programmes', $f['q'] ?? null);
        $push('programmes', $f['a'] ?? null);
    }
}

// Sample alumni reviews rendered (and translated) on every programme page.
foreach (DoctorateProgrammes::SAMPLE_REVIEWS as $rev) {
    $push('sampleReviews', $rev['review'] ?? null);
}

// ── FAQ sets (HomeController, CoursesController, + future Blade pages) ──────
foreach ([
    Faqs::HOME,
    Faqs::COURSES,
    Faqs::SCHOLARSHIP,
    Faqs::CORPORATE,
    Faqs::ABOUT,
    Faqs::DOCTORATE,
] as $set) {
    foreach ($set as $f) {
        $push('faqs', $f['question'] ?? null);
        $push('faqs', $f['answer'] ?? null);
    }
}

// ── Sanity: every section must extract a plausible number of strings ────────
$minimums = [
    'universities' => 30,
    'cards' => 30,
    'programmes' => 500,
    'sampleReviews' => 3,
    'faqs' => 40,
];
foreach ($minimums as $section => $min) {
    $count = count($sections[$section] ?? []);
    if ($count < $min) {
        fwrite(STDERR, "FAIL: section '{$section}' extracted only {$count} strings (expected >= {$min}) — extraction looks broken.\n");
        exit(1);
    }
}

$texts = array_values(array_unique(array_merge(...array_values($sections))));
echo json_encode($texts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), "\n";
