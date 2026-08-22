<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Foundation-level assertions for the Blade frontend port: routing, locale
 * selection, RTL, fallback and cookie persistence.
 */
class FoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_returns_200(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false);
    }

    public function test_arabic_sets_rtl_and_lang(): void
    {
        $this->get('/?lng=ar')
            ->assertStatus(200)
            ->assertSee('dir="rtl"', false)
            ->assertSee('lang="ar"', false);
    }

    public function test_hindi_renders_hindi_navbar_string(): void
    {
        // nav.courses in hi.json => "सभी पाठ्यक्रम"
        $this->get('/?lng=hi')
            ->assertStatus(200)
            ->assertSee('सभी पाठ्यक्रम', false)
            ->assertSee('lang="hi"', false);
    }

    public function test_invalid_lng_falls_back_to_english(): void
    {
        $this->get('/?lng=xx')
            ->assertStatus(200)
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false);
    }

    public function test_valid_lng_sets_persistent_cookie(): void
    {
        $response = $this->get('/?lng=de');
        $response->assertStatus(200);

        $cookie = collect($response->headers->getCookies())
            ->first(fn ($c) => $c->getName() === 'lng');

        $this->assertNotNull($cookie, 'lng cookie should be set');
        $this->assertSame('de', $cookie->getValue());
    }

    public function test_cookie_persistence_selects_locale(): void
    {
        // With the cookie present and no query param, the cookie wins.
        $this->withUnencryptedCookie('lng', 'fr')
            ->get('/')
            ->assertStatus(200)
            ->assertSee('lang="fr"', false);
    }

    public function test_unknown_path_returns_custom_404(): void
    {
        $this->get('/definitely-not-a-real-page')
            ->assertStatus(404)
            ->assertSee(t('notFound.title'), false);
    }

    public function test_unknown_api_path_still_returns_json_404(): void
    {
        // The web fallback must NOT swallow /api/* 404s — they stay JSON.
        $this->getJson('/api/definitely-not-a-real-endpoint')
            ->assertStatus(404)
            ->assertJson(['error' => 'Not found.']);
    }
}
