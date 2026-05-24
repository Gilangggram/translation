<?php

namespace App\Services;

use App\hasDataRange;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stall;
use Illuminate\Support\Facades\Cache;

class RevenueService {

    use hasDataRange;

    // --- Public Methods ---

    public function getCafeRevenue(String $timeframe): int {

        return Cache::remember("cafe_revenue_sum_{$timeframe}", 1, function () use ($timeframe) {
            return $this->queryCafeRevenue($timeframe);
        }); 
    }

    public function getCafeRevenueTrend(string $timeframe): array
    {
        if ($timeframe === 'today') return [];

        return Cache::remember("cafe_revenue_trend_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryCafeRevenueTrend($timeframe);
        });
    }

    public function getStallsRevenue(string $timeframe): array
    {
        return Cache::remember("stalls_revenue_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryStallsRevenue($timeframe);
        });
    }

    // --- Private Query Methods ---

    private function queryCafeRevenue(String $timeframe): int {

        return Order::where('payment_status', 'paid')
            ->where('is_completed', true)
            ->where('created_at', '>=', $this->getStartDate($timeframe))
            ->sum('total_price');

    }

    private function queryCafeRevenueTrend(string $timeframe): array
    {
        [$iteration, $timeFormat] = match($timeframe) {
            '7d'  => [6,  '%Y-%m-%d'],
            '30d' => [29, '%Y-%m-%d'],
            '12m' => [11, '%Y-%m'],
        };

        $data = Order::selectRaw("DATE_FORMAT(created_at, '{$timeFormat}') as period, SUM(total_price) as revenue")
            ->where('payment_status', 'paid')
            ->where('is_completed', true)
            ->where('created_at', '>=', $this->getStartDate($timeframe))
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('revenue', 'period');
 
        $dates        = [];
        $cafe_revenue = [];
 
        for ($i = $iteration; $i >= 0; $i--) {
            $date = match($timeframe) {
                '7d', '30d' => now()->subDays($i),
                '12m'       => now()->subMonths($i),
            };
 
            $dates[]        = match($timeframe) {
                '7d', '30d' => $date->translatedFormat('d M'),
                '12m'       => $date->translatedFormat('M Y'),
            };
 
            $cafe_revenue[] = $data[$date->format(match($timeframe) {
                '7d', '30d' => 'Y-m-d',
                '12m'       => 'Y-m',
            })] ?? 0;
        }
 
        return compact('dates', 'cafe_revenue');
    }

    private function queryStallsRevenue(string $timeframe): array
    {
        $itemsFilterQuery = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
        ->where('orders.payment_status', 'paid')
        ->where('orders.is_completed', true)
        ->where('orders.created_at', '>=', $this->getStartDate($timeframe))
        ->select('order_items.menu_id', 'order_items.total_price');

        return Stall::selectRaw('stalls.stall_id as stall_id, stalls.name as stall_name, COALESCE(SUM(oi.total_price), 0) as stall_revenue')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->leftJoinSub($itemsFilterQuery, 'oi', 'menus.menu_id', '=', 'oi.menu_id')
            ->groupBy('stalls.stall_id', 'stalls.name')
            ->get()
            ->toArray();
    }
}