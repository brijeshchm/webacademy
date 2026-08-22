<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    // ── Health ───────────────────────────────────────────────────────────────

    public function test_healthz_returns_ok(): void
    {
        $this->getJson('/api/healthz')
             ->assertStatus(200)
             ->assertExactJson(['status' => 'ok']);
    }

    // ── Stats ────────────────────────────────────────────────────────────────

    public function test_stats_returns_expected_shape(): void
    {
        $response = $this->getJson('/api/stats');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'careersTransformed',
                     'expertTrainers',
                     'workshopsPerMonth',
                     'countries',
                     'totalCourses',
                     'averageRating',
                 ]);

        $this->assertEquals(65000, $response->json('careersTransformed'));
        $this->assertEquals(4.8, $response->json('averageRating'));
    }

    // ── Categories ───────────────────────────────────────────────────────────

    public function test_categories_returns_empty_array_when_no_data(): void
    {
        $this->getJson('/api/categories')
             ->assertStatus(200)
             ->assertExactJson([]);
    }

    public function test_categories_returns_all_categories(): void
    {
        Category::create([
            'slug'              => 'tech',
            'name'              => 'Technology',
            'tagline'           => 'Build the future',
            'description'       => 'Tech courses',
            'icon_key'          => 'tech',
            'course_count'      => 5,
            'rating'            => 4.8,
            'learners_enrolled' => 100,
        ]);

        $this->getJson('/api/categories')
             ->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['slug' => 'tech']);
    }

    public function test_category_show_returns_404_for_unknown_slug(): void
    {
        $this->getJson('/api/categories/nonexistent')
             ->assertStatus(404)
             ->assertJsonFragment(['error' => 'Category not found']);
    }

    public function test_category_show_returns_category_by_slug(): void
    {
        Category::create([
            'slug'              => 'leadership',
            'name'              => 'Leadership',
            'tagline'           => 'Lead well',
            'description'       => 'Leadership courses',
            'icon_key'          => 'lead',
            'course_count'      => 3,
            'rating'            => 4.9,
            'learners_enrolled' => 50,
        ]);

        $this->getJson('/api/categories/leadership')
             ->assertStatus(200)
             ->assertJsonFragment(['slug' => 'leadership', 'name' => 'Leadership']);
    }

    // ── Courses ──────────────────────────────────────────────────────────────

    private function makeCourse(array $overrides = []): Course
    {
        return Course::create(array_merge([
            'slug'           => 'test-course-' . uniqid(),
            'title'          => 'Test Course',
            'category_slug'  => 'tech',
            'category_name'  => 'Technology',
            'level'          => 'Beginner',
            'summary'        => 'A great course about Python and data.',
            'description'    => 'Full description here.',
            'duration_hours' => 10,
            'mode'           => 'Online',
            'price'          => 0,
            'rating'         => 4.5,
            'total_rating'   => 10,
            'enrolled'       => 50,
            'featured'       => false,
            'skills'         => ['Python', 'Data Analysis'],
            'image_url'      => '',
            'curriculum'     => [],
            'faq'            => [],
        ], $overrides));
    }

    public function test_courses_returns_all_courses(): void
    {
        $this->makeCourse();
        $this->makeCourse();

        $this->getJson('/api/courses')
             ->assertStatus(200)
             ->assertJsonCount(2);
    }

    public function test_courses_filtered_by_category(): void
    {
        $this->makeCourse(['category_slug' => 'tech']);
        $this->makeCourse(['category_slug' => 'finance']);

        $this->getJson('/api/courses?category=tech')
             ->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['category_slug' => 'tech']);
    }

    public function test_courses_filtered_by_featured(): void
    {
        $this->makeCourse(['featured' => true]);
        $this->makeCourse(['featured' => false]);

        $this->getJson('/api/courses?featured=true')
             ->assertStatus(200)
             ->assertJsonCount(1);
    }

    public function test_courses_search_matches_title(): void
    {
        $this->makeCourse(['title' => 'Python for Beginners', 'summary' => 'Learn Python basics.', 'skills' => ['Python']]);
        $this->makeCourse(['title' => 'Advanced Java', 'summary' => 'Master Java development.', 'skills' => ['Java']]);

        $this->getJson('/api/courses?search=Python')
             ->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['title' => 'Python for Beginners']);
    }

    public function test_courses_search_matches_skills_json(): void
    {
        $this->makeCourse(['skills' => ['Machine Learning', 'TensorFlow'], 'title' => 'ML Basics']);
        $this->makeCourse(['skills' => ['JavaScript', 'React'], 'title' => 'Web Dev']);

        $response = $this->getJson('/api/courses?search=TensorFlow');
        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['title' => 'ML Basics']);
    }

    public function test_course_show_returns_404_for_unknown_slug(): void
    {
        $this->getJson('/api/courses/does-not-exist')
             ->assertStatus(404)
             ->assertJsonFragment(['error' => 'Course not found']);
    }

    public function test_course_show_returns_course_by_slug(): void
    {
        $course = $this->makeCourse(['slug' => 'my-specific-course', 'title' => 'My Specific Course']);

        $this->getJson('/api/courses/my-specific-course')
             ->assertStatus(200)
             ->assertJsonFragment(['title' => 'My Specific Course']);
    }

    // ── Testimonials (public) ────────────────────────────────────────────────

    public function test_testimonials_returns_only_visible(): void
    {
        Testimonial::create([
            'name' => 'Visible User', 'role' => 'Dev', 'company' => 'Co',
            'quote' => 'Great!', 'rating' => 5, 'source' => 'google', 'visible' => true,
        ]);
        Testimonial::create([
            'name' => 'Hidden User', 'role' => 'Dev', 'company' => 'Co',
            'quote' => 'Hmm.', 'rating' => 3, 'source' => 'google', 'visible' => false,
        ]);

        $this->getJson('/api/testimonials')
             ->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['name' => 'Visible User']);
    }

    public function test_testimonials_filtered_by_source(): void
    {
        Testimonial::create([
            'name' => 'Google User', 'role' => 'Dev', 'company' => 'Co',
            'quote' => 'Great!', 'rating' => 5, 'source' => 'google', 'visible' => true,
        ]);
        Testimonial::create([
            'name' => 'LinkedIn User', 'role' => 'Dev', 'company' => 'Co',
            'quote' => 'Nice!', 'rating' => 4, 'source' => 'linkedin', 'visible' => true,
        ]);

        $this->getJson('/api/testimonials?source=google')
             ->assertStatus(200)
             ->assertJsonCount(1)
             ->assertJsonFragment(['name' => 'Google User']);
    }

    // ── Lead validation ──────────────────────────────────────────────────────

    public function test_lead_submission_requires_name_and_email(): void
    {
        $this->postJson('/api/leads', [])
             ->assertStatus(422);
    }

    public function test_lead_submission_rejects_invalid_email(): void
    {
        $this->postJson('/api/leads', ['name' => 'Alice', 'email' => 'not-an-email'])
             ->assertStatus(422);
    }

    // ── 404 for unknown routes ───────────────────────────────────────────────

    public function test_unknown_route_returns_404(): void
    {
        $this->getJson('/api/does-not-exist')
             ->assertStatus(404);
    }
}
