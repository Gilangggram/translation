<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class RevenueService {

    public function getCafeRevenueSum(String $timeframe): float {

        return Cache::remember("stat_revenue_{$timeframe}", 60, function () use ($timeframe) {
            return match($timeframe) { 
                'today'  => $this->getTodayCafeRevenueData(),  
                'thisWeek' => $this->getThisWeekCafeRevenueData(),
                'thisMonth'  => $this->getThisMonthCafeRevenueData(),
                'thisYear'  => $this->getThisYearCafeRevenueData(),
            };
        }); 
    }
    
    private function getTodayCafeRevenueData(): int {
        
        return Order::where('payment_status', 'paid')
            ->whereDate('created_at', '=', now()) 
            ->sum('total_price');
    }

    private function getThisWeekCafeRevenueData(): int {

        return Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfWeek(), now()])
            ->sum('total_price');
    }

    private function getThisMonthCafeRevenueData(): int {

        return Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->sum('total_price');
    }

    private function getThisYearCafeRevenueData(): int {

        return Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfYear(), now()])
            ->sum('total_price');
    }

    
}