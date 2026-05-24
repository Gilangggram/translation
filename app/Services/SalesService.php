<?php

namespace App\Services;

use App\hasDataRange;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Cache;

class SalesService {

    use hasDataRange;

    public function getTotalItemsSold(String $timeframe): int { 

        return Cache::remember("item_sales_count_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryTotalItemsSold($timeframe);
        }); 

    }

    public function getMenuSales(String $timeframe): array
    {
        return Cache::remember("menu_sales_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryMenuSales($timeframe);
        });
    }

    public function getMenuSalesByStall(string $timeframe): array
    {
        return Cache::remember("menu_sales_by_stall_{$timeframe}", 60, function () use ($timeframe) {
            return $this->queryMenuSalesByStall($timeframe);
        });
    }

    private function queryTotalItemsSold(String $timeframe): int {

        return OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.is_completed', true)
            ->where('orders.created_at', '>=', $this->getStartDate($timeframe))
            ->sum('quantity');

    }

    private function queryMenuSales(String $timeframe): array
    {
    
        $itemsFilterQuery = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.is_completed', true)
            ->where('orders.created_at', '>=', $this->getStartDate($timeframe))
            ->select('order_items.menu_id', 'order_items.quantity');
 
        return Menu::selectRaw('menus.name as menu_name, COALESCE(SUM(oi.quantity), 0) as menu_sales')
            ->leftJoinSub($itemsFilterQuery, 'oi', 'menus.menu_id', '=', 'oi.menu_id')
            ->groupBy('menus.menu_id', 'menus.name')
            ->get()
            ->toArray();
    }

    private function queryMenuSalesByStall(string $timeframe): array
    {
        return OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
            ->join('stalls', 'menus.stall_id', '=', 'stalls.stall_id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.is_completed', true)
            ->where('orders.created_at', '>=', $this->getStartDate($timeframe))
            ->selectRaw('
                stalls.name                  as stall_name,
                menus.name                   as menu_name,
                SUM(order_items.quantity)    as menu_sales,
                SUM(order_items.total_price) as menu_revenue
            ')
            ->groupBy('stalls.stall_id', 'stalls.name', 'menus.menu_id', 'menus.name')
            ->orderBy('stalls.name')
            ->get()
            ->groupBy('stall_name')
            ->map(fn($items) => $items->values()->toArray())
            ->toArray();
    }

}

