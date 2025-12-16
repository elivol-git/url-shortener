<?php

namespace App\Support;

class BotDetector
{
    public static function isBot(?string $userAgent): bool
    {
        if (!$userAgent) {
            return true;
        }

        $ua = strtolower($userAgent);

        foreach (config('bots.patterns') as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
