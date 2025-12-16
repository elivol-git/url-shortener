<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\LinkHit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Link;

class LinkController extends Controller
{
    public function store(StoreLinkRequest $request)
    {
        $linkData = $request->validated();

        $link = Link::create([
            'slug' => $linkData['slug']?? Str::random(6),
            'target_url' => $linkData['target_url'],
        ]);

        return response()->json([
            'short_url' => url('r/'.$link->slug),
        ], 201);
    }

    public function updateAvailability(UpdateLinkRequest $request, string $slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (! $link) {
            abort(404, 'Link not found');
        }

        $link->update([
            'is_active' => $request->validated('is_active'),
        ]);

        return response()->json([
            'message' => 'Link availability successfully updated',
            'slug' => $link->slug,
            'is_active' => $link->is_active,
        ]);

    }

    public function slugStats(string $slug)
    {
        return Cache::remember(
            key: "slug_stats:{$slug}",
            ttl: 60,
            callback: function () use ($slug) {

                $link = Link::where('slug', $slug)->firstOrFail();

                if (! $link) {
                    abort(404, 'Link not found');
                }

                $totalHits = $link->hits()->count();

                $lastHits = $link->hits()
                    ->latest('created_at')
                    ->limit(5)
                    ->get()
                    ->map(fn ($hit) => [
                        'timestamp' => $hit->created_at->toDateTimeString(),
                        'ip' => preg_replace('/\.\d+$/', '.xxx', $hit->ip),
                    ]);

                return [
                    'target_url' => $link->target_url,
                    'total_hits' => $totalHits,
                    'last_hits' => $lastHits,
                ];

            }
        );
    }
}
