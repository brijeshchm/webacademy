<?php

namespace Tests\Feature\Web;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CourseSelectTranslationTest extends TestCase
{
    use RefreshDatabase;

    private function seedCourses(int $n = 40): void
    {
        for ($i = 1; $i <= $n; $i++) {
            Course::create([
                'slug' => "course-$i",
                'title' => "Course $i",
                'category_slug' => 'data-science',
                'category_name' => 'Data Science',
                'level' => 'Beginner',
                'summary' => "Summary $i",
                'description' => "Description $i",
                'duration_hours' => 40,
                'mode' => 'Online Live',
                'price' => 0,
                'rating' => 4.6,
                'total_rating' => 10,
                'enrolled' => 100,
            ]);
        }
    }

    private function assertBoundedTranslationQueries(string $url, int $max = 3): void
    {
        $count = 0;
        DB::listen(function ($query) use (&$count) {
            if (str_contains($query->sql, 'translations')) {
                $count++;
            }
        });

        $this->get($url)->assertOk();
        $this->assertLessThanOrEqual($max, $count, "Expected <= $max translations-table queries for $url, got $count");
    }

    public function test_enquiry_page_batches_course_title_translations(): void
    {
        $this->seedCourses();
        $this->assertBoundedTranslationQueries('/enquiry?lng=fr');
    }

    public function test_scholarship_page_batches_course_title_translations(): void
    {
        $this->seedCourses();
        $this->assertBoundedTranslationQueries('/scholarship?lng=fr');
    }
}
