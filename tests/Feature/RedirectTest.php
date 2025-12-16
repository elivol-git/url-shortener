<?php

namespace Feature;

use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Link;

class RedirectTest extends TestCase
{
    use RefreshDatabase;
    const TARGET_URL = 'https://film-planets.test';

    public function test_active_link_redirects()
    {
        $link = Link::factory()->create([
            'slug' => 'star-wars',
            'target_url' => self::TARGET_URL,
            'is_active' => true,
        ]);

        $response = $this->get("/r/{$link->slug}");

        $response
            ->assertStatus(302)
            ->assertRedirect(self::TARGET_URL);
    }

    public function test_non_existing_slug_returns_404()
    {
        $this->get('/r/this-slug-does-not-exist')
            ->assertStatus(404);
    }

    public function test_inactive_link_returns_410()
    {
        $link = Link::factory()->create([
            'slug' => 'inactive-link',
            'is_active' => false,
        ]);

        $this->get("/r/{$link->slug}")
            ->assertStatus(410);
    }

    public function test_bot_user_agent_is_not_logged()
    {
        Queue::fake();

        $link = Link::factory()->create([
            'is_active' => true,
        ]);

        $this->withHeader('User-Agent', 'YandexBot/3.0')
            ->get("/r/{$link->slug}");

        Queue::assertNothingPushed();
    }
}
