<?php

namespace App;

use Carbon\Carbon;

trait hasDataRange
{
    private function getStartDate(string $timeframe): string|Carbon
    {
        return match($timeframe) {
            'today' => now()->startOfDay(),
            '7d'    => now()->subDays(6)->startOfDay(),
            '30d'   => now()->subDays(29)->startOfDay(),
            '12m'   => now()->subMonths(12)->startOfMonth()->startOfDay(),
        };
    }
}
