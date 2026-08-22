<?php

namespace Tests\Feature\Web;

use App\Models\Course;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Server-rendered /courses and /courses/{slug} pages ported from React.
 *
 * Covers: listing renders with seeded data, search + category filters,
 * course-detail 200 + JSON-LD, unknown slug 404, Arabic dir="rtl", and the
 * course-detail enquiry lead form (plain POST persists + redirects, no JS).
 */
class CoursesWebTest extends TestCase
{
    use RefreshDatabase;

    private function makeCourse(array $overrides = []): Course
    {
        static $counter = 0;
        $counter++;

        return Course::create(array_merge([
            'slug'           => 'course-' . $counter,
            'title'          => 'Default Title ' . $counter,
            'category_slug'  => 'data-science',
            'category_name'  => 'Data Science',
            'level'          => 'Beginner',
            'summary'        => 'A standard course summary.',
            'description'    => 'Full description paragraph one.',
            'duration_hours' => 40,
            'mode'           => 'Online Live',
            'price'          => 0,
            'rating'         => 4.6,
            'total_rating'   => 128,
            'enrolled'       => 3400,
            'featured'       => false,
            'skills'         => ['Python', 'Pandas'],
            'image_url'      => '',
            'curriculum'     => [
                ['title' => 'Module One', 'topics' => ['Topic A', 'Topic B']],
            ],
            'faq'            => [
                ['question' => 'Is this beginner friendly?', 'answer' => 'Yes it is.'],
            ],
        ], $overrides));
    }

    /* ── /courses listing ─────────────────────────────────────── */

    public function test_courses_index_returns_200_with_seeded_data(): void
    {
        $this->makeCourse(['slug' => 'python-for-data-science', 'title' => 'Python for Data Science']);

        $this->get('/courses')
            ->assertStatus(200)
            ->assertSee('Python for Data Science', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"@type":"ItemList"', false);
    }

    public function test_courses_index_search_filters_results(): void
    {
        $this->makeCourse(['slug' => 'python-for-data-science', 'title' => 'Python for Data Science']);
        $this->makeCourse([
            'slug'          => 'ethical-hacking',
            'title'         => 'Ethical Hacking',
            'category_slug' => 'cyber-security',
            'category_name' => 'Cyber Security',
            'summary'       => 'Penetration testing.',
            'skills'        => ['Kali'],
        ]);

        $this->get('/courses?search=hacking')
            ->assertStatus(200)
            ->assertSee('Ethical Hacking', false)
            ->assertDontSee('Python for Data Science', false);
    }

    public function test_courses_index_category_filter(): void
    {
        $this->makeCourse(['slug' => 'ds-course', 'title' => 'Data Science Course', 'category_slug' => 'data-science']);
        $this->makeCourse([
            'slug'          => 'cs-course',
            'title'         => 'Cyber Course',
            'category_slug' => 'cyber-security',
            'category_name' => 'Cyber Security',
        ]);

        $this->get('/courses?category=cyber-security')
            ->assertStatus(200)
            ->assertSee('Cyber Course', false)
            ->assertDontSee('Data Science Course', false);
    }

    public function test_courses_index_arabic_sets_rtl(): void
    {
        $this->makeCourse();

        $this->get('/courses?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    /* ── /courses/{slug} detail ───────────────────────────────── */

    public function test_course_detail_returns_200_with_content_and_jsonld(): void
    {
        $this->makeCourse(['slug' => 'python-basics', 'title' => 'Python Basics']);

        $this->get('/courses/python-basics')
            ->assertStatus(200)
            ->assertSee('Python Basics', false)
            ->assertSee('"@type":"Course"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('Module One', false)
            ->assertSee('Is this beginner friendly?', false);
    }

    public function test_course_detail_unknown_slug_returns_404(): void
    {
        $this->get('/courses/does-not-exist')->assertStatus(404);
    }

    /**
     * JSON-LD script-injection regression: a stored '</script>' payload in a
     * mutable DB field must be hex-escaped (\u003C) when json_encoded into the
     * inline <script type="application/ld+json"> block, so it can never
     * terminate the script tag and break out into executable HTML.
     */
    public function test_course_detail_jsonld_escapes_script_breakout_payload(): void
    {
        $payload = '</script><script>alert(1)</script>';

        $this->makeCourse([
            'slug'    => 'xss-course',
            'title'   => 'Safe Title ' . $payload,
            'summary' => 'Safe summary ' . $payload,
        ]);

        $response = $this->get('/courses/xss-course')->assertStatus(200);
        $html = $response->getContent();

        // Isolate the JSON-LD <script> blocks and assert the raw closing tag
        // never appears inside them (it would break out of the tag).
        preg_match_all(
            '#<script type="application/ld\+json">(.*?)</script>#s',
            $html,
            $matches
        );
        $this->assertNotEmpty($matches[1], 'Expected at least one JSON-LD script block.');

        foreach ($matches[1] as $block) {
            $this->assertStringNotContainsString(
                '</script>',
                $block,
                'Raw </script> leaked into JSON-LD contents — script tag can be broken out of.'
            );
            $this->assertStringNotContainsString('<script>', $block);
        }

        // The payload must be present, but only in the hex-escaped form.
        // JSON_HEX_TAG escapes '<' -> \u003C and '>' -> \u003E; without
        // JSON_UNESCAPED_SLASHES the '/' is also escaped to '\/'.
        $response->assertSee('\u003C\/script\u003E', false);
    }

    public function test_course_detail_arabic_sets_rtl(): void
    {
        $this->makeCourse(['slug' => 'python-basics']);

        $this->get('/courses/python-basics?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    public function test_course_detail_enquiry_form_stores_and_redirects(): void
    {
        $this->makeCourse(['slug' => 'python-basics', 'title' => 'Python Basics']);

        $response = $this->post('/courses/python-basics/enquiry', [
            'name'  => 'Detail Enquirer',
            'email' => 'detail@example.com',
            'phone' => '+919000000010',
        ]);

        $response->assertRedirect();

        $lead = Lead::where('email', 'detail@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertEquals('Detail Enquirer', $lead->name);
        $this->assertStringContainsString('Python Basics', $lead->message);
    }

    /**
     * Regression: rendering /courses in a non-English locale with many seeded
     * courses must run only a small, CONSTANT number of queries against the
     * `translations` table (one batched whereIn for titles + FAQ strings),
     * never one-per-course. Mirrors HomeTest's bounded-query regression.
     */
    public function test_courses_index_uses_bounded_translation_queries(): void
    {
        for ($i = 1; $i <= 40; $i++) {
            $this->makeCourse([
                'slug'  => 'bounded-course-' . $i,
                'title' => 'Bounded Course ' . $i,
            ]);
        }

        $count = 0;
        DB::listen(function ($query) use (&$count): void {
            if (str_contains($query->sql, '"translations"') || str_contains($query->sql, '`translations`')) {
                $count++;
            }
        });

        $this->get('/courses?lng=fr')->assertStatus(200);

        $this->assertLessThanOrEqual(
            3,
            $count,
            "/courses ran {$count} translations-table queries; expected a bounded number (<= 3)."
        );
    }

    /**
     * Regression: the course-detail page collects ALL dynamic strings
     * (summary, description, skills, curriculum titles + topics, FAQ q/a)
     * into ONE batched translateMany() call. A course with a rich curriculum
     * and FAQ payload must run at most one translations-table query at render.
     */
    public function test_course_detail_uses_bounded_translation_queries(): void
    {
        $this->makeCourse([
            'slug'        => 'bounded-detail',
            'title'       => 'Bounded Detail Course',
            'skills'      => ['Skill A', 'Skill B', 'Skill C', 'Skill D'],
            'curriculum'  => [
                ['title' => 'Module One', 'topics' => ['Topic A1', 'Topic A2', 'Topic A3']],
                ['title' => 'Module Two', 'topics' => ['Topic B1', 'Topic B2']],
                ['title' => 'Module Three', 'topics' => ['Topic C1', 'Topic C2', 'Topic C3']],
            ],
            'faq'         => [
                ['question' => 'Question one?', 'answer' => 'Answer one.'],
                ['question' => 'Question two?', 'answer' => 'Answer two.'],
                ['question' => 'Question three?', 'answer' => 'Answer three.'],
            ],
        ]);

        $count = 0;
        DB::listen(function ($query) use (&$count): void {
            if (str_contains($query->sql, '"translations"') || str_contains($query->sql, '`translations`')) {
                $count++;
            }
        });

        $this->get('/courses/bounded-detail?lng=fr')->assertStatus(200);

        $this->assertLessThanOrEqual(
            2,
            $count,
            "/courses/{slug} ran {$count} translations-table queries; expected <= 2 (one batched call)."
        );
    }
}
