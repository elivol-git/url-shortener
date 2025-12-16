<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LinkHitCreated;
use App\Listeners\ClearSlugStatsCache;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        LinkHitCreated::class => [
            ClearSlugStatsCache::class,
        ],
    ];

}
