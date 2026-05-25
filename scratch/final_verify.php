<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;

echo "=== PESANAN MASUK yang akan tampil (is_completed=false, bukan cancelled) ===\n";
$orders = Order::where('is_completed', false)
    ->whereNotIn('payment_status', ['cancelled'])
    ->with(['orderItems.menu', 'table'])
    ->orderBy('created_at', 'asc')
    ->get();

echo "Total: " . $orders->count() . "\n\n";
foreach ($orders as $o) {
    $meja = $o->table ? 'Meja ' . $o->table->table_number : 'Takeaway';
    echo "#{$o->order_number} | payment={$o->payment_status} | {$meja} | items=" . $o->orderItems->count() . "\n";
}

echo "\n=== KPI Pesanan Masuk (count) ===\n";
$count = Order::where('is_completed', false)->whereNotIn('payment_status', ['cancelled'])->count();
echo "Count: {$count}\n";

echo "\n=== Riwayat Selesai hari ini ===\n";
$done = Order::where('is_completed', true)->whereDate('created_at', \Carbon\Carbon::today())->get();
echo "Count: " . $done->count() . "\n";
