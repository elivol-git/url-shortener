<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function __invoke(string $slug): RedirectResponse
    {
        $link = Link::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return redirect()->away($link->target_url);
    }
}
