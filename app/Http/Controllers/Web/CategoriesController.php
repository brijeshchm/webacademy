<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Services\ServerTranslator;
use Illuminate\View\View;

/**
 * Server-rendered /categories and /categories/{slug} pages. Mirrors the JSON
 * API (CategoryController@index / @show + CourseController@index?category=).
 */
class CategoriesController extends Controller
{
    public function index(): View
    {
        // Match the API/React ordering (categories by insertion id, not name).
        $categories = Category::orderBy('id')->get();

        // Translate dynamic DB text (taglines + descriptions) for non-English
        // in ONE batched translations-table query.
        $taglineSrc     = $categories->pluck('tagline')->all();
        $descriptionSrc = $categories->pluck('description')->all();
        $n = count($taglineSrc);

        $translated   = ServerTranslator::translateMany(array_merge($taglineSrc, $descriptionSrc));
        $taglines     = array_slice($translated, 0, $n);
        $descriptions = array_slice($translated, $n);

        $translatedTaglines = [];
        $translatedDescriptions = [];
        foreach (array_values($categories->all()) as $i => $cat) {
            $translatedTaglines[$cat->id]     = $taglines[$i] ?? $cat->tagline;
            $translatedDescriptions[$cat->id] = $descriptions[$i] ?? $cat->description;
        }

        return view('pages.categories', [
            'categories'             => $categories,
            'translatedTaglines'     => $translatedTaglines,
            'translatedDescriptions' => $translatedDescriptions,
        ]);
    }

    public function show(string $slug): View
    {
        $category = Category::where('category_slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        // Courses in this category — same shape as CourseController@index?category=.
        $courses = Course::where('category_slug', $slug)->orderBy('id')->get();

        // ── Batch-translate ALL dynamic strings in ONE query ────────────
        // Collect the category tagline + description and every course title +
        // summary, resolve the whole deduped set through a single
        // translateMany() call (one whereIn), then map results back via an
        // "original => translated" lookup map.
        $allStrings = array_merge(
            [$category->tagline, $category->description],
            $courses->pluck('title')->all(),
            $courses->pluck('summary')->all(),
        );

        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

        $tDyn = static fn (?string $v): ?string => (is_string($v) && $v !== '' && isset($translations[$v])) ? $translations[$v] : $v;

        $tagline     = $tDyn($category->tagline);
        $description = $tDyn($category->description);

        $translatedTitles = [];
        $translatedSummaries = [];
        foreach ($courses as $course) {
            $translatedTitles[$course->id]    = $tDyn($course->title);
            $translatedSummaries[$course->id] = $tDyn($course->summary);
        }

        return view('pages.category-detail', [
            'category'            => $category,
            'courses'             => $courses,
            'taglineT'            => $tagline,
            'descriptionT'        => $description,
            'translatedTitles'    => $translatedTitles,
            'translatedSummaries' => $translatedSummaries,
        ]);
    }

    /**
     * Build an "original => translated" lookup map from two parallel arrays.
     * Blank originals are skipped; callers fall back to the original string.
     *
     * @param  array<int,?string>  $originals
     * @param  array<int,?string>  $translated
     * @return array<string,string>
     */
    private static function lookupMap(array $originals, array $translated): array
    {
        $map = [];
        foreach ($originals as $i => $original) {
            if (is_string($original) && $original !== '') {
                $map[$original] = $translated[$i] ?? $original;
            }
        }

        return $map;
    }
}
