<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stall;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RevenueChartService {

    public function getCafeRevenueTrend(string $timeframe): array
    {
        return Cache::remember("stat_revenue_trend_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryGetCafeRevenueTrend($timeframe);
        });
    }

    public function getEachStallRevenue(string $timeframe): array
    {
        return Cache::remember("stat_each_stall_revenue_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryGetEachStallRevenue($timeframe);
        });
    }

    private function queryGetCafeRevenueTrend(string $timeframe): array
    {
        [$startDate, $iteration] = match($timeframe) {
            '7d'  => [now()->subDays(6)->startOfDay(), 6],
            '30d' => [now()->subDays(29)->startOfDay(), 29],
            '12m' => [now()->subMonths(12)->startOfMonth(), 11],
        };

        $timeFormat = match($timeframe) {
            '7d', '30d' => '%Y-%m-%d',
            '12m'       => '%Y-%m',
        };

        $data = Order::selectRaw("DATE_FORMAT(created_at, '{$timeFormat}') as period, SUM(total_price) as revenue")
        ->where('payment_status', 'paid')
        ->where('created_at', '>=', $startDate)
        ->groupBy('period')
        ->orderBy('period')
        ->pluck('revenue', 'period');

        $labels = [];
        $values = [];

        for ($i = $iteration; $i >= 0; $i--) {
            $date = match($timeframe) {
                '7d', '30d' => now()->subDays($i),
                '12m' => now()->subMonths($i),
            };
            $labels[] = match($timeframe) {
                '7d', '30d' => $date->translatedFormat('d M'),
                '12m' => $date->translatedFormat('M Y'),
            };
            $values[] = $data[$date->format(match($timeframe) {
                '7d', '30d' => 'Y-m-d',
                '12m' => 'Y-m',
            })] ?? 0;
        }

        return compact('labels', 'values');
    }

    private function queryGetEachStallRevenue(string $timeframe): array
    {
        $startDate = match($timeframe) {
            '7d'  => now()->subDays(6)->startOfDay(),
            '30d' => now()->subDays(29)->startOfDay(),
            '12m' => now()->subMonths(12)->startOfMonth()->startOfDay(),
        };

        $itemsFilterQuery = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
        ->where('orders.payment_status', 'paid')
        ->where('orders.created_at', '>=', $startDate)
        ->select('order_items.menu_id', 'order_items.total_price');

        $data = Stall::selectRaw('stalls.name as stall_name, COALESCE(SUM(oi.total_price), 0) as revenue')
            ->leftJoin('menus', 'stalls.stall_id', '=', 'menus.stall_id')
            ->leftJoinSub($itemsFilterQuery, 'oi', 'menus.menu_id', '=', 'oi.menu_id')
            ->groupBy('stalls.stall_id', 'stalls.name')
            ->get()
            ->toArray();

        $labels = array_column($data, 'stall_name');
        $values = array_column($data, 'revenue');

        return compact('labels', 'values');
    }
    
}

