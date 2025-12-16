<?php

namespace Feature;

use App\Models\Link;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLinkTest extends TestCase
{
    use RefreshDatabase;

    const TARGET_URL = 'https://film-planets.test';

    public function test_can_create_short_link()
    {
        $response = $this->postJson('/api/links', [
            'target_url' => self::TARGET_URL
        ], [
            'X-Api-Key' => config('app.api_key'),
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'short_url',
            ]);

        $this->assertDatabaseCount('links', 1);

        $this->assertDatabaseHas('links', [
            'target_url' => self::TARGET_URL,
        ]);
    }

    public function test_request_fails_without_api_key()
    {
        $response = $this->postJson('/api/links', [
            'target_url' => self::TARGET_URL
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid API key',
            ]);
    }

    public function test_request_fails_with_wrong_api_key()
    {
        $response = $this->postJson('/api/links', [
            'target_url' => self::TARGET_URL,
        ], [
            'X-Api-Key' => 'wrong-key',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid API key',
            ]);
    }

    public function test_can_update_link_availability()
    {
        $link = Link::factory()->create([
            'slug' => 'star-wars',
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            "/api/links/{$link->slug}",
            [
                'is_active' => false,
            ],
            [
                'X-Api-Key' => config('app.api_key'),
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'slug' => 'star-wars',
                'is_active' => false,
            ]);

        $this->assertDatabaseHas('links', [
            'slug' => 'star-wars',
            'is_active' => false,
        ]);
    }
}
