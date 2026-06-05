<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Stall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StallController extends Controller
{
    private function getActiveStall()
    {
        $stallAccount = Auth::guard('stall')->user();
        if ($stallAccount) {
            return $stallAccount->stall;
        }
        return Stall::whereHas('menus')->first() ?? Stall::first();
    }

    public function dashboard(Request $request)
    {
        $stall = $this->getActiveStall();
        if (!$stall) {
            abort(404, 'Stall tidak ditemukan. Silakan tambahkan data stall di database.');
        }
        $stallId = $stall->stall_id;

        // ── KPI 1: Total Pesanan (semua order aktif yang berisi menu stall ini, bukan cancelled) ──
        $totalOrders = Order::whereNotIn('payment_status', ['cancelled'])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->count();

        // ── KPI 2: Total Pendapatan stall ini (order paid) ──
        $totalRevenue = OrderItem::whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
            ->sum('total_price');

        // ── KPI 3: Pesanan Masuk — semua order aktif yang belum selesai yang berisi menu stall ini ──
        $incomingOrdersCount = Order::where('is_completed', false)
            ->whereNotIn('payment_status', ['cancelled'])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->count();

        // ── KPI 4: Menu Tersedia / Total (spesifik stall ini) ──
        $totalMenus     = Menu::where('stall_id', $stallId)->count();
        $availableMenus = Menu::where('stall_id', $stallId)->where('is_available', true)->count();

        // ── Donut Chart: Menu Terlaris stall ini ──
        $topMenus = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->take(3)
            ->with('menu')
            ->get();

        $menuData  = [];
        $totalSold = 0;

        foreach ($topMenus as $item) {
            if ($item->menu) {
                $menuData[] = ['name' => $item->menu->name, 'qty' => (int) $item->total_qty];
                $totalSold  += (int) $item->total_qty;
            }
        }

        if (!empty($menuData)) {
            $remaining = 100;
            foreach ($menuData as $idx => &$item) {
                if ($idx === count($menuData) - 1) {
                    $item['percentage'] = max(0, $remaining);
                } else {
                    $perc               = $totalSold > 0 ? round(($item['qty'] / $totalSold) * 100) : 0;
                    $item['percentage'] = $perc;
                    $remaining         -= $perc;
                }
            }
            unset($item);
        }

        // ── Tren Pendapatan: 30 hari terakhir (Dapat di-filter) ──
        $trendDays = $request->input('trend_days');
        if (!in_array($trendDays, [7, 30])) {
            $trendDays = 7;
            $check7 = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
                ->where('menus.stall_id', $stallId)
                ->where('orders.payment_status', 'paid')
                ->whereBetween('orders.created_at', [
                    Carbon::now()->subDays(6)->startOfDay(),
                    Carbon::now()->endOfDay(),
                ])->count();
            if ($check7 === 0) {
                $trendDays = 30;
            }
        } else {
            $trendDays = (int) $trendDays;
        }

        $revenueRows = OrderItem::select(
                DB::raw('DATE(orders.created_at) as order_date'),
                DB::raw('SUM(order_items.total_price) as daily_total')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
            ->where('menus.stall_id', $stallId)
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [
                Carbon::now()->subDays($trendDays - 1)->startOfDay(),
                Carbon::now()->endOfDay(),
            ])
            ->groupBy('order_date')
            ->pluck('daily_total', 'order_date')
            ->toArray();

        $revenueData = [];
        for ($i = $trendDays - 1; $i >= 0; $i--) {
            $date    = Carbon::now()->subDays($i)->toDateString();
            if ($trendDays <= 7) {
                $dayNamesMap = [
                    'Monday' => 'Sen', 'Tuesday' => 'Sel', 'Wednesday' => 'Rab',
                    'Thursday' => 'Kam', 'Friday' => 'Jum', 'Saturday' => 'Sab', 'Sunday' => 'Min',
                ];
                $label = $dayNamesMap[Carbon::now()->subDays($i)->format('l')] ?? Carbon::now()->subDays($i)->format('D');
            } else {
                $label = ($i % 5 === 0 || $i === $trendDays - 1 || $i === 0)
                    ? Carbon::now()->subDays($i)->format('d/m')
                    : '';
            }
            $revenueData[] = [
                'day'    => $label,
                'amount' => (float) ($revenueRows[$date] ?? 0),
            ];
        }

        $numPoints  = count($revenueData);
        $xStart     = 30;
        $xEnd       = 450;
        $xStep      = $numPoints > 1 ? ($xEnd - $xStart) / ($numPoints - 1) : 0;
        $xCoords    = [];
        for ($xi = 0; $xi < $numPoints; $xi++) {
            $xCoords[] = round($xStart + $xi * $xStep);
        }
        $maxAmount = max(array_column($revenueData, 'amount'));

        $points = [];
        foreach ($revenueData as $idx => $data) {
            $x = $xCoords[$idx];
            $y = $maxAmount > 0
                ? round(120 - ($data['amount'] / $maxAmount) * 100, 2)
                : 120;
            $points[] = [
                'x'      => $x,
                'y'      => $y,
                'amount' => $data['amount'],
                'day'    => $data['day'],
            ];
        }

        $linePath = '';
        $areaPath = '';
        if (count($points) > 0) {
            $linePath = 'M ' . $points[0]['x'] . ' ' . $points[0]['y'];
            for ($i = 1; $i < count($points); $i++) {
                $prev     = $points[$i - 1];
                $curr     = $points[$i];
                $cpx1     = $prev['x'] + ($curr['x'] - $prev['x']) * 0.4;
                $cpy1     = $prev['y'];
                $cpx2     = $prev['x'] + ($curr['x'] - $prev['x']) * 0.6;
                $cpy2     = $curr['y'];
                $linePath .= " C {$cpx1} {$cpy1}, {$cpx2} {$cpy2}, {$curr['x']} {$curr['y']}";
            }
            $lastPt   = $points[count($points) - 1];
            $firstPt  = $points[0];
            $areaPath = $linePath . " L {$lastPt['x']} 120 L {$firstPt['x']} 120 Z";
        }

        $highestIdx = -1;
        $highestVal = -1;
        foreach ($points as $idx => $pt) {
            if ($pt['amount'] > $highestVal) {
                $highestVal = $pt['amount'];
                $highestIdx = $idx;
            }
        }

        // ── Tabel Riwayat: 10 order selesai terbaru ──
        $completedOrders = Order::where('is_completed', true)
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->with([
                'orderItems' => fn($q) => $q
                    ->whereHas('menu', fn($m) => $m->where('stall_id', $stallId))
                    ->with('menu'),
                'table',
            ])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        $trendLabel = $trendDays <= 7 ? '7 Hari Terakhir' : '30 Hari Terakhir';

        return view('staff.stall.dashboard', compact(
            'stall', 'totalOrders', 'totalRevenue', 'incomingOrdersCount',
            'totalMenus', 'availableMenus', 'menuData', 'totalSold', 'completedOrders',
            'points', 'linePath', 'areaPath', 'highestIdx', 'trendLabel', 'trendDays'
        ));
    }

    public function pesananMasuk(Request $request)
    {
        $stall = $this->getActiveStall();
        if (!$stall) {
            abort(404, 'Stall tidak ditemukan. Silakan tambahkan data stall di database.');
        }
        $stallId = $stall->stall_id;

        $orders = Order::where('is_completed', false)
            ->whereNotIn('payment_status', ['cancelled'])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->with([
                'orderItems' => function ($q) use ($stallId) {
                    $q->whereHas('menu', function ($m) use ($stallId) {
                        $m->where('stall_id', $stallId);
                    })->with('menu');
                },
                'table',
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($orders as $order) {
            $stallItems   = $order->orderItems;
            $order->stall_total_price = $stallItems->sum('total_price');
            $itemStatuses = $stallItems->pluck('status');

            if ($itemStatuses->isNotEmpty() && $itemStatuses->every(fn($s) => $s === 'served')) {
                $order->stall_status = 'SELESAI';
            } else {
                $cached = Cache::get("stall_{$stallId}_order_{$order->order_id}_status");
                $order->stall_status = $cached ? strtoupper($cached) : 'MENUNGGU';
            }
        }

        $semuaCount    = $orders->count();
        $menungguCount = $orders->filter(fn($o) => $o->stall_status === 'MENUNGGU')->count();
        $dimasakCount  = $orders->filter(fn($o) => $o->stall_status === 'DIMASAK')->count();

        $search = $request->input('search');
        $filter = $request->input('filter', 'semua');

        if ($search) {
            $orders = $orders->filter(
                fn($o) => str_contains(strtolower($o->order_number), strtolower($search))
            )->values();
        }

        if ($filter === 'menunggu') {
            $orders = $orders->filter(fn($o) => $o->stall_status === 'MENUNGGU')->values();
        } elseif ($filter === 'dimasak') {
            $orders = $orders->filter(fn($o) => $o->stall_status === 'DIMASAK')->values();
        }

        return view('staff.stall.pesananmasuk', compact(
            'stall', 'orders', 'semuaCount', 'menungguCount', 'dimasakCount', 'filter', 'search'
        ));
    }

    public function prosesOrder(Request $request, $orderId)
    {
        $stall   = $this->getActiveStall();
        $stallId = $stall ? $stall->stall_id : 'default';

        DB::transaction(function () use ($orderId, $stallId) {
            OrderItem::where('order_id', $orderId)
                ->whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
                ->where('status', '!=', 'served')
                ->update(['status' => 'preparing']);
        });

        Cache::put("stall_{$stallId}_order_{$orderId}_status", 'dimasak', now()->addHours(24));

        return redirect()->back()->with('success', 'Pesanan sedang dimasak.');
    }

    public function siapSajikanOrder(Request $request, $orderId)
    {
        $stall   = $this->getActiveStall();
        $stallId = $stall ? $stall->stall_id : 'default';

        DB::transaction(function () use ($orderId, $stallId) {
            OrderItem::where('order_id', $orderId)
                ->whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
                ->where('status', 'preparing')
                ->update(['status' => 'served']);
        });

        Cache::forget("stall_{$stallId}_order_{$orderId}_status");

        $order = Order::find($orderId);
        if ($order) {
            $order->checkAndCompleteOrder();
        }

        return redirect()->back()->with('success', 'Pesanan siap disajikan!');
    }

    public function toggleStatus(Request $request)
    {
        $stall = $this->getActiveStall();
        if (!$stall) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Stall tidak ditemukan.'], 404);
            }
            return redirect()->back()->withErrors('Stall tidak ditemukan.');
        }

        $stall->update(['is_open' => !$stall->is_open]);
        $statusStr = $stall->is_open ? 'dibuka' : 'ditutup';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'is_open' => (bool) $stall->is_open,
                'message' => "Stall berhasil {$statusStr}!",
            ]);
        }

        return redirect()->back()->with('success', "Stall berhasil {$statusStr}!");
    }
}
