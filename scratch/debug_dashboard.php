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
echo "Stall: {$stall->name}\n\n";

// --- CEK ORDER SELESAI & TANGGALNYA ---
echo "=== SEMUA ORDER SELESAI (is_completed=true) ===\n";
$done = Order::where('is_completed', true)->get();
foreach ($done as $o) {
    echo "  #{$o->order_number} | payment={$o->payment_status} | created_at={$o->created_at}\n";
}

// --- CEK TABEL: order selesai hari ini ---
echo "\n=== Tabel: order selesai HARI INI (" . Carbon::today()->toDateString() . ") ===\n";
$todayDone = Order::where('is_completed', true)->whereDate('created_at', Carbon::today())->get();
echo "Count: " . $todayDone->count() . "\n";

// --- CEK TABEL: order selesai 7 hari ---
echo "\n=== Tabel: order selesai 7 hari terakhir ===\n";
$weekDone = Order::where('is_completed', true)
    ->where('created_at', '>=', Carbon::now()->subDays(7)->startOfDay())
    ->get();
echo "Count: " . $weekDone->count() . "\n";
foreach ($weekDone as $o) {
    echo "  #{$o->order_number} | created_at={$o->created_at}\n";
}

// --- CEK TREN: revenue per hari (stall ini, paid) ---
echo "\n=== Tren: revenue 7 hari terakhir (order_items milik stall, paid) ===\n";
$rows = OrderItem::select(
        DB::raw('DATE(orders.created_at) as order_date'),
        DB::raw('SUM(order_items.total_price) as daily_total')
    )
    ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
    ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
    ->where('menus.stall_id', $stallId)
    ->where('orders.payment_status', 'paid')
    ->whereBetween('orders.created_at', [
        Carbon::now()->subDays(6)->startOfDay(),
        Carbon::now()->endOfDay(),
    ])
    ->groupBy('order_date')
    ->get();
echo "Rows found: " . $rows->count() . "\n";
foreach ($rows as $r) {
    echo "  date={$r->order_date} total={$r->daily_total}\n";
}

// --- CEK SEMUA ORDER_ITEMS ---
echo "\n=== Semua order_items & tanggal order ===\n";
$items = OrderItem::select(
        'order_items.order_item_id',
        'order_items.total_price',
        'order_items.status',
        'orders.payment_status',
        'orders.is_completed',
        'orders.created_at as order_date'
    )
    ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
    ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
    ->where('menus.stall_id', $stallId)
    ->get();
foreach ($items as $it) {
    echo "  item_id={$it->order_item_id} total={$it->total_price} payment={$it->payment_status} date={$it->order_date}\n";
}

// --- CEK REVENUE TANPA FILTER TANGGAL ---
echo "\n=== Revenue SEMUA waktu (no date filter) ===\n";
$allRevenue = OrderItem::select(
        DB::raw('DATE(orders.created_at) as order_date'),
        DB::raw('SUM(order_items.total_price) as daily_total')
    )
    ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
    ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
    ->where('menus.stall_id', $stallId)
    ->where('orders.payment_status', 'paid')
    ->groupBy('order_date')
    ->get();
echo "Rows: " . $allRevenue->count() . "\n";
foreach ($allRevenue as $r) {
    echo "  date={$r->order_date} total={$r->daily_total}\n";
}
