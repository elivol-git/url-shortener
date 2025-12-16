<?php

namespace App\Listeners;

use App\Events\LinkHitCreated;
use App\Models\Link;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class ClearSlugStatsCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LinkHitCreated $event): void
    {
        $link = Link::find($event->linkId);

        if ($link) {
            Cache::forget("slug_stats:{$link->slug}");
        }
    }
}
