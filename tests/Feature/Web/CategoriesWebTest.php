<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Server-rendered /categories and /categories/{slug} pages ported from React.
 *
 * Covers: index 200 with seeded categories, detail 200 listing its courses,
 * detail JSON-LD (Breadcrumb + ItemList + FAQ), unknown slug 404, and Arabic
 * dir="rtl".
 */
class CategoriesWebTest extends TestCase
{
    use RefreshDatabase;

    private function makeCategory(array $overrides = []): Category
    {
        static $counter = 0;
        $counter++;

        return Category::create(array_merge([
            'slug'              => 'category-' . $counter,
            'name'              => 'Category ' . $counter,
            'tagline'           => 'A useful tagline.',
            'description'       => 'A helpful category description.',
            'icon_key'          => 'data-science',
            'course_count'      => 3,
            'rating'            => 4.7,
            'learners_enrolled' => 12000,
        ], $overrides));
    }

    private function makeCourse(string $categorySlug, string $categoryName, array $overrides = []): Course
    {
        static $counter = 0;
        $counter++;

        return Course::create(array_merge([
            'slug'           => 'course-' . $counter,
            'title'          => 'Course ' . $counter,
            'category_slug'  => $categorySlug,
            'category_name'  => $categoryName,
            'level'          => 'Beginner',
            'summary'        => 'A standard course summary.',
            'description'    => 'Full description.',
            'duration_hours' => 30,
            'mode'           => 'Online Live',
            'price'          => 0,
            'rating'         => 4.5,
            'total_rating'   => 40,
            'enrolled'       => 900,
            'featured'       => false,
            'skills'         => [],
            'image_url'      => '',
            'curriculum'     => [],
            'faq'            => [],
        ], $overrides));
    }

    /* ── /categories index ────────────────────────────────────── */

    public function test_categories_index_returns_200_with_seeded_data(): void
    {
        $this->makeCategory(['slug' => 'data-science', 'name' => 'Data Science']);

        $this->get('/categories')
            ->assertStatus(200)
            ->assertSee('Data Science', false);
    }

    public function test_categories_index_arabic_sets_rtl(): void
    {
        $this->makeCategory();

        $this->get('/categories?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    /* ── /categories/{slug} detail ────────────────────────────── */

    public function test_category_detail_returns_200_with_courses_and_jsonld(): void
    {
        $this->makeCategory(['slug' => 'data-science', 'name' => 'Data Science']);
        $this->makeCourse('data-science', 'Data Science', ['title' => 'Intro to ML']);

        $this->get('/categories/data-science')
            ->assertStatus(200)
            ->assertSee('Data Science', false)
            ->assertSee('Intro to ML', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('"@type":"ItemList"', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_category_detail_unknown_slug_returns_404(): void
    {
        $this->get('/categories/does-not-exist')->assertStatus(404);
    }

    public function test_category_detail_arabic_sets_rtl(): void
    {
        $this->makeCategory(['slug' => 'data-science', 'name' => 'Data Science']);

        $this->get('/categories/data-science?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    /**
     * Regression: the category-detail page collects the category tagline +
     * description and every course title + summary into ONE batched
     * translateMany() call. A category with several courses must run at most
     * one translations-table query at render, never one-per-course.
     */
    public function test_category_detail_uses_bounded_translation_queries(): void
    {
        $this->makeCategory(['slug' => 'data-science', 'name' => 'Data Science']);
        for ($i = 1; $i <= 12; $i++) {
            $this->makeCourse('data-science', 'Data Science', [
                'title'   => 'Bounded Course ' . $i,
                'summary' => 'Bounded summary ' . $i,
            ]);
        }

        $count = 0;
        DB::listen(function ($query) use (&$count): void {
            if (str_contains($query->sql, '"translations"') || str_contains($query->sql, '`translations`')) {
                $count++;
            }
        });

        $this->get('/categories/data-science?lng=fr')->assertStatus(200);

        $this->assertLessThanOrEqual(
            2,
            $count,
            "/categories/{slug} ran {$count} translations-table queries; expected <= 2 (one batched call)."
        );
    }
}
