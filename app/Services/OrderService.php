<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class OrderService {

    public function getCompletedOrdersSum(String $timeframe): int { 

        return Cache::remember("completed_orders_sum_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryCompletedOrdersNumber($timeframe);
        });

    }

    private function queryCompletedOrdersNumber(String $timeframe): int {

        $query = Order::where('payment_status', 'paid')
            ->where('is_completed', true);

        $query = match($timeframe) { 
            'today'  => $query->whereDate('created_at', now()),
            'thisWeek' => $query->whereBetween('created_at', [now()->startOfWeek(), now()]),
            'thisMonth'  => $query->whereBetween('created_at', [now()->startOfMonth(), now()]),
            'thisYear'  => $query->whereBetween('created_at', [now()->startOfYear(), now()]),
        };

        return $query->count();

    }

    
}