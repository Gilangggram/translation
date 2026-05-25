<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stall;
use Illuminate\Support\Facades\DB;

echo "=== STALLS ===\n";
$stalls = Stall::all();
foreach ($stalls as $s) {
    echo "stall_id={$s->stall_id} name={$s->name} is_open=" . ($s->is_open ? 'true' : 'false') . "\n";
}

echo "\n=== ORDERS (total) ===\n";
echo "Total: " . Order::count() . "\n";

echo "\n=== ORDERS by payment_status ===\n";
$statuses = Order::select('payment_status', DB::raw('count(*) as cnt'))->groupBy('payment_status')->get();
foreach ($statuses as $s) {
    echo "payment_status={$s->payment_status} count={$s->cnt}\n";
}

echo "\n=== ORDERS by is_completed ===\n";
$comps = Order::select('is_completed', DB::raw('count(*) as cnt'))->groupBy('is_completed')->get();
foreach ($comps as $c) {
    echo "is_completed={$c->is_completed} count={$c->cnt}\n";
}

echo "\n=== ORDER_ITEMS by status ===\n";
$itemStatuses = OrderItem::select('status', DB::raw('count(*) as cnt'))->groupBy('status')->get();
foreach ($itemStatuses as $s) {
    echo "item_status={$s->status} count={$s->cnt}\n";
}

echo "\n=== ORDERS is_completed=false ===\n";
$pending = Order::where('is_completed', false)->with('orderItems')->get();
echo "Count: " . $pending->count() . "\n";
foreach ($pending as $o) {
    echo "  order_id={$o->order_id} order_number={$o->order_number} payment={$o->payment_status} items=" . $o->orderItems->count() . "\n";
    foreach ($o->orderItems as $item) {
        echo "    item_id={$item->order_item_id} menu_id={$item->menu_id} status={$item->status}\n";
    }
}

echo "\n=== ORDERS is_completed=false AND payment_status=paid ===\n";
$paidPending = Order::where('is_completed', false)->where('payment_status', 'paid')->get();
echo "Count: " . $paidPending->count() . "\n";
