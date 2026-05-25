<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Stall;

// Ambil stall pertama
$stall = Stall::whereHas('menus')->first() ?? Stall::first();
if (!$stall) { echo "Tidak ada stall!\n"; exit; }
$stallId = $stall->stall_id;
echo "Stall: {$stall->name} (id={$stallId})\n\n";

// Test query pesanan masuk baru
$orders = Order::where('is_completed', false)
    ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
    ->with(['orderItems' => fn($q) => $q->with('menu'), 'table'])
    ->orderBy('created_at', 'asc')
    ->get();

echo "=== Pesanan Masuk (is_completed=false, punya item dari stall ini) ===\n";
echo "Total: " . $orders->count() . "\n";
foreach ($orders as $o) {
    $stallItems = $o->orderItems->filter(fn($i) => $i->menu && $i->menu->stall_id == $stallId);
    echo "  #{$o->order_number} payment={$o->payment_status} items_stall=" . $stallItems->count() . "\n";
    foreach ($stallItems as $item) {
        echo "    - " . ($item->menu->name ?? 'n/a') . " qty={$item->quantity} status={$item->status}\n";
    }
}

echo "\n=== Riwayat Selesai hari ini ===\n";
$completed = Order::where('is_completed', true)
    ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
    ->whereDate('created_at', \Carbon\Carbon::today())
    ->get();
echo "Total: " . $completed->count() . "\n";

echo "\n=== KPI incomingOrdersCount ===\n";
$kpi = Order::where('is_completed', false)
    ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
    ->count();
echo "Count: {$kpi}\n";
