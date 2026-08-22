<?php

namespace Tests\Feature\Web;

use App\Models\Course;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Server-rendered marketing pages ported from React: /about, /contact,
 * /enquiry, /scholarship, /corporate-training, plus the public /leads intake.
 *
 * Each page returns 200 with seeded Course data, exposes its key content and
 * JSON-LD, renders dir="rtl" for ?lng=ar, and every lead form POST persists a
 * Lead and redirects back with a success flash (works without JS).
 */
class StaticPagesWebTest extends TestCase
{
    use RefreshDatabase;

    private function seedCourse(string $slug = 'python-basics', string $title = 'Python Basics'): Course
    {
        return Course::create([
            'slug'           => $slug,
            'title'          => $title,
            'category_slug'  => 'data-science',
            'category_name'  => 'Data Science',
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
        ]);
    }

    /* ── /about ──────────────────────────────────────────────── */

    public function test_about_returns_200_with_content_and_jsonld(): void
    {
        $this->seedCourse();

        $this->get('/about')
            ->assertStatus(200)
            ->assertSee('"@type":["Organization","EducationalOrganization"]', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('65k+', false); // careersTransformed stat, humanised
    }

    public function test_about_arabic_sets_rtl(): void
    {
        $this->get('/about?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    /* ── /contact ────────────────────────────────────────────── */

    public function test_contact_returns_200_with_form_and_jsonld(): void
    {
        $this->get('/contact')
            ->assertStatus(200)
            ->assertSee('"@type":"ContactPage"', false)
            ->assertSee('action="' . route('leads.store') . '"', false);
    }

    public function test_contact_lead_form_stores_and_redirects(): void
    {
        $response = $this->post('/leads', [
            'name'    => 'Contact Person',
            'email'   => 'contact@example.com',
            'phone'   => '+919000000001',
            'message' => 'I have a general question.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('leads', [
            'name'    => 'Contact Person',
            'email'   => 'contact@example.com',
            'message' => 'I have a general question.',
        ]);
    }

    /* ── /enquiry ────────────────────────────────────────────── */

    public function test_enquiry_returns_200_with_course_options(): void
    {
        $this->seedCourse('workday-hcm', 'Workday HCM');

        $this->get('/enquiry')
            ->assertStatus(200)
            ->assertSee('name="form_type"', false)
            ->assertSee('value="enquiry"', false)
            ->assertSee('Workday HCM', false); // course option
    }

    public function test_enquiry_lead_form_stores_composed_message(): void
    {
        $this->seedCourse('workday-hcm', 'Workday HCM');

        $response = $this->post('/leads', [
            'form_type'      => 'enquiry',
            'name'           => 'Enquiry Person',
            'email'          => 'enq@example.com',
            'phone'          => '+919000000002',
            'courseInterest' => 'Workday HCM',
            'message'        => 'Please share the syllabus.',
        ]);

        $response->assertRedirect();

        $lead = Lead::where('email', 'enq@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertStringContainsString('Course interest: Workday HCM', $lead->message);
        $this->assertStringContainsString('Please share the syllabus.', $lead->message);
    }

    /* ── /scholarship ────────────────────────────────────────── */

    public function test_scholarship_returns_200_with_content_and_jsonld(): void
    {
        $this->seedCourse();

        $this->get('/scholarship')
            ->assertStatus(200)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('name="form_type"', false)
            ->assertSee('value="scholarship"', false)
            ->assertSee('id="apply"', false);
    }

    public function test_scholarship_arabic_sets_rtl(): void
    {
        $this->get('/scholarship?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    public function test_scholarship_lead_form_stores_composed_message(): void
    {
        $this->seedCourse('data-analytics', 'Data Analytics');

        $response = $this->post('/leads', [
            'form_type'      => 'scholarship',
            'name'           => 'Scholar Applicant',
            'email'          => 'scholar@example.com',
            'phone'          => '+919000000003',
            'lastEducation'  => 'Bachelor\'s Degree (B.Tech / B.E)',
            'percentage'     => '82.5',
            'cgpa'           => '8.4',
            'courseInterest' => 'Data Analytics',
            'message'        => 'I am the first in my family to pursue tech.',
        ]);

        $response->assertRedirect();

        $lead = Lead::where('email', 'scholar@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertStringContainsString('Scholarship Application', $lead->message);
        $this->assertStringContainsString('Percentage: 82.5%', $lead->message);
        $this->assertStringContainsString('CGPA: 8.4', $lead->message);
        $this->assertStringContainsString('Course Interest: Data Analytics', $lead->message);
    }

    /* ── /corporate-training ─────────────────────────────────── */

    public function test_corporate_returns_200_with_content_and_jsonld(): void
    {
        $this->get('/corporate-training')
            ->assertStatus(200)
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('name="form_type"', false)
            ->assertSee('value="corporate"', false)
            ->assertSee('id="enquiry"', false);
    }

    public function test_corporate_arabic_sets_rtl(): void
    {
        $this->get('/corporate-training?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false);
    }

    public function test_corporate_lead_form_stores_composed_message(): void
    {
        $response = $this->post('/leads', [
            'form_type' => 'corporate',
            'name'      => 'Corp Buyer',
            'email'     => 'corp@example.com',
            'phone'     => '+919000000004',
            'company'   => 'Acme Corp',
            'teamSize'  => '21–50 people',
            'timeline'  => '1–3 months',
            'program'   => 'Leadership and manager development',
            'goals'     => 'Upskill our engineering managers.',
        ]);

        $response->assertRedirect();

        $lead = Lead::where('email', 'corp@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertStringContainsString('Company: Acme Corp', $lead->message);
        $this->assertStringContainsString('Team size: 21–50 people', $lead->message);
        $this->assertStringContainsString('Program context: Leadership and manager development', $lead->message);
    }
}
