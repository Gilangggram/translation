<?php

namespace App\Services;

use App\hasDataRange;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class OrderService {

    use hasDataRange;

    public function getCompletedOrdersCount(String $timeframe): int { 

        return Cache::remember("completed_orders_count_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryCompletedOrdersCount($timeframe);
        });

    }

    public function getOrderTypeStats(string $timeframe): array
    {
        return Cache::remember("order_type_stats_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryOrderTypeStats($timeframe);
        });
    }

    private function queryCompletedOrdersCount(string $timeframe): int
    {
        return Order::where('payment_status', 'paid')
            ->where('is_completed', true)
            ->where('created_at', '>=', $this->getStartDate($timeframe))
            ->count();
    }


    private function queryOrderTypeStats(string $timeframe): array
    {
        return Order::selectRaw('order_type, COUNT(*) as count')
            ->where('payment_status', 'paid')
            ->where('is_completed', true)
            ->where('created_at', '>=', $this->getStartDate($timeframe))
            ->groupBy('order_type')
            ->get()
            ->pluck('count', 'order_type')
            ->toArray();
    }
    
}