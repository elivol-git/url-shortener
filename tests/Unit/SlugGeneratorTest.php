<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;

class SlugGeneratorTest extends TestCase
{
    public function test_slug_is_unique()
    {
        $slugs = collect();

        for ($i = 0; $i < 1000; $i++) {
            $slugs->push(Str::random(6));
        }

        $this->assertCount(
            $slugs->unique()->count(),
            $slugs,
            'Generated slugs are not unique'
        );
    }

    public function test_slug_has_allowed_characters_only()
    {
        $slug = Str::random(6);

        $this->assertMatchesRegularExpression(
            '/^[A-Za-z0-9]+$/',
            $slug
        );
    }

    public function test_slug_has_correct_length()
    {
        $this->assertSame(6, strlen(Str::random(6)));
    }
}
