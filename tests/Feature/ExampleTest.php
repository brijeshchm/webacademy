<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * This file intentionally left minimal.
 * API coverage is in ApiTest.php and AdminAuthTest.php.
 */
class ExampleTest extends TestCase
{
    public function test_health_endpoint_returns_ok(): void
    {
        $response = $this->getJson('/api/healthz');

        $response->assertStatus(200)
                 ->assertJson(['status' => 'ok']);
    }
}
