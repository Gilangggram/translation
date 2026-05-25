<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stall;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$stall   = Stall::whereHas('menus')->first() ?? Stall::first();
$stallId = $stall->stall_id;

// --- CEK TREN (30 hari) ---
$revenueRows = OrderItem::select(
        DB::raw('DATE(orders.created_at) as order_date'),
        DB::raw('SUM(order_items.total_price) as daily_total')
    )
    ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
    ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
    ->where('menus.stall_id', $stallId)
    ->where('orders.payment_status', 'paid')
    ->whereBetween('orders.created_at', [
        Carbon::now()->subDays(29)->startOfDay(),
        Carbon::now()->endOfDay(),
    ])
    ->groupBy('order_date')
    ->pluck('daily_total', 'order_date')
    ->toArray();

echo "=== TREN 30 hari ===\n";
echo "Data rows: " . count($revenueRows) . "\n";
foreach ($revenueRows as $d => $t) {
    echo "  $d = Rp " . number_format($t) . "\n";
}

$maxAmount = !empty($revenueRows) ? max($revenueRows) : 0;
echo "Max amount: " . number_format($maxAmount) . "\n";
echo "Chart AKAN TAMPIL: " . ($maxAmount > 0 ? 'YA ✅' : 'TIDAK (semua nol)') . "\n";

// --- CEK TABEL (10 terbaru) ---
echo "\n=== TABEL: 10 order selesai terbaru ===\n";
$completed = Order::where('is_completed', true)
    ->orderByDesc('created_at')
    ->take(10)
    ->get();
echo "Count: " . $completed->count() . "\n";
foreach ($completed as $o) {
    echo "  #{$o->order_number} | payment={$o->payment_status} | created_at={$o->created_at}\n";
}
