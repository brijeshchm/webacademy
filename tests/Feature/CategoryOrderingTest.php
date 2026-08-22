<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Regression: the category ordering contract is "insertion id", matching the
 * original Express API. The JSON API and every Blade page that lists
 * categories must agree, so alphabetical drift can't reappear on one side.
 */
class CategoryOrderingTest extends TestCase
{
    use RefreshDatabase;

    /** Names deliberately reverse-alphabetical vs id order. */
    private function seedCategories(): void
    {
        foreach ([[1, 'zeta-skills', 'Zeta Skills'], [2, 'midway-lab', 'Midway Lab'], [3, 'alpha-track', 'Alpha Track']] as [$id, $slug, $name]) {
            Category::create([
                'id' => $id,
                'slug' => $slug,
                'name' => $name,
                'tagline' => 't',
                'description' => 'd',
                'icon_key' => 'code',
                'course_count' => 1,
                'rating' => 4.8,
                'learners_enrolled' => 10,
            ]);
        }
    }

    public function test_api_returns_categories_in_id_order(): void
    {
        $this->seedCategories();

        $names = collect($this->getJson('/api/categories')->assertStatus(200)->json())
            ->pluck('name')->all();

        $this->assertSame(['Zeta Skills', 'Midway Lab', 'Alpha Track'], $names);
    }

    public function test_blade_pages_list_categories_in_id_order(): void
    {
        $this->seedCategories();

        foreach (['/categories', '/courses', '/'] as $path) {
            $this->get($path)
                 ->assertStatus(200)
                 ->assertSeeInOrder(['Zeta Skills', 'Midway Lab', 'Alpha Track']);
        }
    }
}
