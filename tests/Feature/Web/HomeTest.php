<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\Course;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Feature coverage for the server-rendered Home page (/), the Blade port of
 * artifacts/corporate-academy/src/pages/Home.tsx.
 */
class HomeTest extends TestCase
{
    use RefreshDatabase;

    private function seedContent(): void
    {
        Category::create([
            'slug'              => 'cloud-computing',
            'name'              => 'Cloud Computing',
            'tagline'           => 'Scale with confidence',
            'description'       => 'Master the cloud.',
            'icon_key'          => 'cloud',
            'course_count'      => 12,
            'rating'            => 4.8,
            'learners_enrolled' => 15000,
        ]);

        Course::create([
            'slug'           => 'aws-solutions-architect',
            'title'          => 'AWS Solutions Architect',
            'category_slug'  => 'cloud-computing',
            'category_name'  => 'Cloud Computing',
            'level'          => 'Intermediate',
            'summary'        => 'Design resilient AWS systems.',
            'description'    => 'Full AWS architect track.',
            'duration_hours' => 40,
            'mode'           => 'Online',
            'price'          => 29900,
            'rating'         => 4.9,
            'total_rating'   => 320,
            'enrolled'       => 8200,
            'featured'       => true,
            'skills'         => ['AWS', 'Networking'],
            'image_url'      => 'https://example.com/aws.jpg',
        ]);

        Testimonial::create([
            'name'       => 'Aisha Rahman',
            'role'       => 'Cloud Engineer',
            'company'    => 'TechCorp',
            'quote'      => 'This program changed my career trajectory completely.',
            'rating'     => 5,
            'avatar_url' => '',
            'source'     => 'linkedin',
            'visible'    => true,
        ]);
    }

    public function test_home_renders_200_with_seeded_content(): void
    {
        $this->seedContent();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false)
            ->assertSee('AWS Solutions Architect')
            ->assertSee('Cloud Computing')
            ->assertSee('Aisha Rahman');
    }

    public function test_home_renders_without_content(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_home_search_form_targets_courses_get(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('data-hero-search', false)
            ->assertSee('name="search"', false);
    }

    public function test_home_includes_faq_jsonld(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('FAQPage', false)
            ->assertSee('#organization', false)
            ->assertSee('SearchAction', false);
    }

    public function test_arabic_home_is_rtl(): void
    {
        $this->seedContent();

        $this->get('/?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    /**
     * Regression for the N+1 translation issue: rendering the home page in a
     * non-English locale with many seeded courses + testimonials must run only
     * a small, CONSTANT number of queries against the `translations` table
     * (one batched whereIn per string group), never one-per-card/per-review.
     */
    public function test_home_non_english_locale_uses_bounded_translation_queries(): void
    {
        Category::create([
            'slug'              => 'cloud-computing',
            'name'              => 'Cloud Computing',
            'tagline'           => 'Scale with confidence',
            'description'       => 'Master the cloud.',
            'icon_key'          => 'cloud',
            'course_count'      => 12,
            'rating'            => 4.8,
            'learners_enrolled' => 15000,
        ]);

        // Seed enough courses that a per-row translate() would balloon the
        // query count well past the bound (skills constellation shows 40).
        for ($i = 1; $i <= 45; $i++) {
            Course::create([
                'slug'           => 'course-' . $i,
                'title'          => 'Course Number ' . $i,
                'category_slug'  => 'cloud-computing',
                'category_name'  => 'Cloud Computing',
                'level'          => 'Intermediate',
                'summary'        => 'Summary for course ' . $i,
                'description'    => 'Description ' . $i,
                'duration_hours' => 40,
                'mode'           => 'Online',
                'price'          => 29900,
                'rating'         => 4.9,
                'total_rating'   => 320,
                'enrolled'       => 8200,
                'featured'       => $i <= 6,
                'skills'         => ['AWS'],
                'image_url'      => '',
            ]);
        }

        for ($i = 1; $i <= 8; $i++) {
            Testimonial::create([
                'name'       => 'Reviewer ' . $i,
                'role'       => 'Engineer ' . $i,
                'company'    => 'Company ' . $i,
                'quote'      => 'Quote number ' . $i . ' about the program.',
                'rating'     => 5,
                'avatar_url' => '',
                'source'     => 'linkedin',
                'visible'    => true,
            ]);
        }

        $translationQueries = 0;
        DB::listen(function ($query) use (&$translationQueries): void {
            if (str_contains($query->sql, '"translations"') || str_contains($query->sql, '`translations`')) {
                $translationQueries++;
            }
        });

        $this->get('/?lng=fr')->assertStatus(200);

        $this->assertLessThanOrEqual(
            5,
            $translationQueries,
            "Home page ran {$translationQueries} translations-table queries; expected a bounded number (<= 5)."
        );
    }
}
