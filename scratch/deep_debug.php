<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Stall;

$stall = Stall::whereHas('menus')->first() ?? Stall::first();
$stallId = $stall->stall_id;
echo "Stall aktif: {$stall->name} (id={$stallId})\n\n";

echo "=== SEMUA ORDER (is_completed=false) ===\n";
$all = Order::where('is_completed', false)
    ->with(['orderItems.menu', 'table'])
    ->orderBy('created_at', 'asc')
    ->get();
echo "Total: " . $all->count() . "\n";
foreach ($all as $o) {
    $items = $o->orderItems;
    $stallItems = $items->filter(fn($i) => $i->menu && $i->menu->stall_id == $stallId);
    echo "  #{$o->order_number} | payment={$o->payment_status} | all_items={$items->count()} | stall_items={$stallItems->count()}\n";
}

echo "\n=== DENGAN whereHas('orderItems.menu', stallId) ===\n";
$filtered = Order::where('is_completed', false)
    ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
    ->get();
echo "Total (setelah filter stall): " . $filtered->count() . "\n";
