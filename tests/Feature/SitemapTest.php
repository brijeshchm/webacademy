<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    private function makeCourse(array $overrides = []): Course
    {
        static $n = 0;
        $n++;

        return Course::create(array_merge([
            'slug' => "test-course-{$n}",
            'title' => "Test Course {$n}",
            'category_slug' => 'hr',
            'category_name' => 'HR',
            'level' => 'Beginner',
            'summary' => 'Summary',
            'description' => 'Description',
            'duration_hours' => 10,
            'mode' => 'Online',
            'price' => 1000,
            'rating' => 4.5,
            'total_rating' => 10,
            'enrolled' => 100,
            'featured' => false,
            'skills' => [],
            'curriculum' => [],
            'faq' => [],
        ], $overrides));
    }

    public function test_sitemap_returns_valid_xml_with_course_urls(): void
    {
        config(['services.site.origin' => 'https://example.com']);

        $this->makeCourse(['slug' => 'hr-analytics']);
        $this->makeCourse(['slug' => 'payroll-basics']);

        $response = $this->get('/api/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $xml);
        $this->assertStringContainsString('<loc>https://example.com/courses/hr-analytics</loc>', $xml);
        $this->assertStringContainsString('<loc>https://example.com/courses/payroll-basics</loc>', $xml);

        // Must parse as valid XML
        $parsed = simplexml_load_string($xml);
        $this->assertNotFalse($parsed);
        $this->assertCount(2, $parsed->url);
    }

    public function test_sitemap_escapes_xml_special_characters_in_slugs(): void
    {
        config(['services.site.origin' => 'https://example.com']);

        $this->makeCourse(['slug' => 'a&b<c>"d\'e']);

        $response = $this->get('/api/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('a&amp;b&lt;c&gt;', $response->getContent());
        $this->assertNotFalse(simplexml_load_string($response->getContent()));
    }

    public function test_sitemap_strips_trailing_slash_from_origin(): void
    {
        config(['services.site.origin' => 'https://example.com/']);

        $this->makeCourse(['slug' => 'hr-analytics']);

        $this->get('/api/sitemap.xml')
            ->assertStatus(200)
            ->assertSee('<loc>https://example.com/courses/hr-analytics</loc>', false);
    }

    public function test_sitemap_with_no_courses_is_still_valid_xml(): void
    {
        $response = $this->get('/api/sitemap.xml');

        $response->assertStatus(200);
        $this->assertNotFalse(simplexml_load_string($response->getContent()));
    }
}
