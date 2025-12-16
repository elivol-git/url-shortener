<?php

namespace App\Http\Controllers;

use App\Jobs\LogLinkHit;
use App\Models\Link;
use App\Support\BotDetector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $slug): RedirectResponse
    {
        $link = Link::where('slug', $slug)->first();

        if (! $link) {
            abort(404);
        }

        if (! $link->is_active) {
            abort(410);
        }

        if (! BotDetector::isBot($request->userAgent())) {
            LogLinkHit::dispatch(
                linkId: $link->id,
                ip: $request->ip(),
                userAgent: $request->userAgent()
            );
        }
        return redirect()->away($link->target_url, 302);
    }
}
