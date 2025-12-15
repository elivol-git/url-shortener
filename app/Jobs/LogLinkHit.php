<?php

namespace App\Jobs;

use App\Models\LinkHit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogLinkHit implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $linkId,
                                public string $ip,
                                public ?string $userAgent)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LinkHit::create([
            'link_id' => $this->linkId,
            'ip' => $this->ip,
            'user_agent' => $this->userAgent,
        ]);
    }
}
