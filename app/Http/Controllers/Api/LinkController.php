<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
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
            'short_url' => url($link->slug),
        ], 201);
    }
}
