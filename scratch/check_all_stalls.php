<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Stall;

$stalls = Stall::with('menus')->get();
echo "=== Semua Stall & Pesanan Masuk ===\n";
foreach ($stalls as $stall) {
    $stallId = $stall->stall_id;
    $count = Order::where('is_completed', false)
        ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
        ->count();
    echo "Stall: {$stall->name} | menus=" . $stall->menus->count() . " | pesanan_masuk={$count}\n";
}

echo "\n=== Detail semua order_items dengan menu stall ===\n";
$items = \App\Models\OrderItem::with(['menu.stall', 'order'])->get();
foreach ($items as $item) {
    echo "item_id={$item->order_item_id} order={$item->order->order_number} menu=" . ($item->menu->name ?? 'n/a') . " stall=" . ($item->menu->stall->name ?? 'n/a') . " status={$item->status} order_complete=" . ($item->order->is_completed ? 'true' : 'false') . "\n";
}
