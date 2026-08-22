<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifies that GET /api/courses?search=<term> returns correct results
 * using the LIKE-based search in CourseController@index.
 *
 * Tests run against SQLite (:memory:) with the same LIKE operator used by
 * MySQL (utf8mb4_general_ci is case-insensitive, matching SQLite LIKE behaviour
 * for ASCII text). Cases cover all four searched columns: title, summary,
 * category_name, and skills (stored as a JSON array).
 */
class CourseSearchTest extends TestCase
{
    use RefreshDatabase;

    // ── Fixtures ──────────────────────────────────────────────────────────────

    private function makeCourse(array $overrides = []): Course
    {
        static $counter = 0;
        $counter++;

        return Course::create(array_merge([
            'slug'           => 'course-' . $counter,
            'title'          => 'Default Title ' . $counter,
            'category_slug'  => 'general',
            'category_name'  => 'General',
            'level'          => 'Beginner',
            'summary'        => 'A standard course summary.',
            'description'    => 'Full description.',
            'duration_hours' => 10,
            'mode'           => 'Online',
            'price'          => 0,
            'rating'         => 4.5,
            'total_rating'   => 0,
            'enrolled'       => 0,
            'featured'       => false,
            'skills'         => [],
            'image_url'      => '',
            'curriculum'     => [],
            'faq'            => [],
        ], $overrides));
    }

    /**
     * Create the standard set of 5 courses used across most tests:
     *
     *   #1  python-for-data-science   — "Python" in title AND skills
     *   #2  machine-learning          — "Python" only in skills, "Scikit-learn" / "TensorFlow" in skills
     *   #3  data-analytics-excel      — "python" only in summary (lowercase)
     *   #4  ethical-hacking-basics    — no Python at all; "Cyber Security" category_name
     *   #5  network-security-pro      — no Python; "Cyber Security" category_name
     */
    private function seedCourses(): void
    {
        $this->makeCourse([
            'slug'          => 'python-for-data-science',
            'title'         => 'Python for Data Science',
            'category_slug' => 'data-science',
            'category_name' => 'Data Science',
            'summary'       => 'Learn data analysis using modern tools.',
            'skills'        => ['Python', 'Pandas', 'NumPy', 'Matplotlib'],
            'featured'      => true,
        ]);

        $this->makeCourse([
            'slug'          => 'machine-learning-fundamentals',
            'title'         => 'Machine Learning Fundamentals',
            'category_slug' => 'data-science',
            'category_name' => 'Data Science',
            'summary'       => 'Core ML algorithms and model evaluation.',
            'skills'        => ['Python', 'Scikit-learn', 'TensorFlow'],
        ]);

        $this->makeCourse([
            'slug'          => 'data-analytics-excel',
            'title'         => 'Data Analytics with Excel',
            'category_slug' => 'data-science',
            'category_name' => 'Data Science',
            // lowercase "python" — tests case-insensitive summary match
            'summary'       => 'Excel analytics; also covers python scripting for automation.',
            'skills'        => ['Excel', 'Pivot Tables', 'Formulas'],
        ]);

        $this->makeCourse([
            'slug'          => 'ethical-hacking-basics',
            'title'         => 'Ethical Hacking Basics',
            'category_slug' => 'cyber-security',
            'category_name' => 'Cyber Security',
            'summary'       => 'Introduction to penetration testing.',
            'skills'        => ['Kali Linux', 'Metasploit', 'Wireshark'],
        ]);

        $this->makeCourse([
            'slug'          => 'network-security-pro',
            'title'         => 'Network Security Pro',
            'category_slug' => 'cyber-security',
            'category_name' => 'Cyber Security',
            'summary'       => 'Advanced network defence strategies.',
            'skills'        => ['Firewalls', 'IDS', 'VPN', 'Wireshark'],
            'featured'      => true,
        ]);
    }

    // ── Tests ─────────────────────────────────────────────────────────────────

    /**
     * Lowercase "python" should match:
     *   - course whose title contains "Python"
     *   - course whose skills JSON contains "Python"
     *   - course whose summary contains "python" (lowercase)
     * It must NOT match courses that have no python-related text.
     */
    public function test_search_python_lowercase_returns_three_courses(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=python');

        $response->assertStatus(200)->assertJsonCount(3);

        $slugs = collect($response->json())->pluck('slug')->all();
        $this->assertContains('python-for-data-science', $slugs, 'Title match missing');
        $this->assertContains('machine-learning-fundamentals', $slugs, 'Skills-only match missing');
        $this->assertContains('data-analytics-excel', $slugs, 'Summary match missing');
        $this->assertNotContains('ethical-hacking-basics', $slugs, 'False positive: hacking course');
        $this->assertNotContains('network-security-pro', $slugs, 'False positive: network security');
    }

    /**
     * Uppercase "Python" must return the same three courses as lowercase "python".
     * This confirms LIKE is case-insensitive on both SQLite and MySQL
     * (MySQL default collation utf8mb4_general_ci is case-insensitive).
     */
    public function test_search_python_uppercase_returns_same_results_case_insensitive(): void
    {
        $this->seedCourses();

        $lower = $this->getJson('/api/courses?search=python')->json();
        $upper = $this->getJson('/api/courses?search=Python')->json();

        $this->assertCount(3, $upper, 'Uppercase search should return 3 results');
        $this->assertEquals(
            collect($lower)->pluck('slug')->sort()->values()->all(),
            collect($upper)->pluck('slug')->sort()->values()->all(),
            '"python" and "Python" must return identical results'
        );
    }

    /**
     * "PYTHON" (all caps) must also return the same three courses.
     */
    public function test_search_python_all_caps_returns_same_results(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=PYTHON');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    /**
     * "scikit" should match only the Machine Learning course via its skills JSON.
     * No other column on any course contains "scikit".
     */
    public function test_search_scikit_matches_skills_json_only(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=scikit');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['slug' => 'machine-learning-fundamentals']);
    }

    /**
     * "tensorflow" is stored as "TensorFlow" in skills. A lowercase query must
     * still match it (case-insensitive LIKE on the JSON text column).
     */
    public function test_search_tensorflow_lowercase_matches_mixed_case_skill(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=tensorflow');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['slug' => 'machine-learning-fundamentals']);
    }

    /**
     * "cyber" should match both Cyber Security courses via category_name.
     */
    public function test_search_cyber_matches_category_name(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=cyber');

        $response->assertStatus(200)->assertJsonCount(2);

        $slugs = collect($response->json())->pluck('slug')->all();
        $this->assertContains('ethical-hacking-basics', $slugs);
        $this->assertContains('network-security-pro', $slugs);
    }

    /**
     * "hacking" appears only in the title of one course; no other course should match.
     */
    public function test_search_hacking_matches_title_only_no_false_positives(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=hacking');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['slug' => 'ethical-hacking-basics']);
    }

    /**
     * A term that exists in no column of any course must return an empty array.
     */
    public function test_search_nonexistent_term_returns_empty_array(): void
    {
        $this->seedCourses();

        $this->getJson('/api/courses?search=zzznomatch')
             ->assertStatus(200)
             ->assertExactJson([]);
    }

    /**
     * When no search parameter is provided, all courses are returned.
     */
    public function test_no_search_param_returns_all_courses(): void
    {
        $this->seedCourses();

        $this->getJson('/api/courses')
             ->assertStatus(200)
             ->assertJsonCount(5);
    }

    /**
     * An empty search string should return all courses (filled() returns false
     * for an empty string, so the WHERE block is skipped).
     */
    public function test_empty_search_param_returns_all_courses(): void
    {
        $this->seedCourses();

        $this->getJson('/api/courses?search=')
             ->assertStatus(200)
             ->assertJsonCount(5);
    }

    /**
     * Partial substring match — "pandas" is a substring of the "Pandas" skill.
     */
    public function test_search_partial_substring_of_skill_matches(): void
    {
        $this->seedCourses();

        $response = $this->getJson('/api/courses?search=pandas');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['slug' => 'python-for-data-science']);
    }
}
