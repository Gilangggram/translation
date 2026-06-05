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

        // ── KPI Period Filter ──
        $kpiDays = (int) $request->input('kpi_days', 30);
        if (!in_array($kpiDays, [7, 30, 365])) {
            $kpiDays = 30;
        }
        $kpiStart = Carbon::now()->subDays($kpiDays - 1)->startOfDay();
        $kpiEnd   = Carbon::now()->endOfDay();

        // ── KPI 1: Total Pesanan dalam periode ──
        $totalOrders = Order::whereNotIn('payment_status', ['cancelled'])
            ->whereBetween('created_at', [$kpiStart, $kpiEnd])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->count();


        // ── KPI 2: Total Pendapatan stall ini (order paid) dalam periode ──
        $totalRevenue = OrderItem::whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [$kpiStart, $kpiEnd]))
            ->sum('total_price');

        // ── KPI 3: Pesanan Masuk — semua order aktif yang belum selesai ──
        $incomingOrdersCount = Order::where('is_completed', false)
            ->whereNotIn('payment_status', ['cancelled'])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->count();


        // ── KPI 4: Menu Tersedia / Total (spesifik stall ini) ──
        $totalMenus     = Menu::where('stall_id', $stallId)->count();
        $availableMenus = Menu::where('stall_id', $stallId)->where('is_available', true)->count();

        // ── Donut Chart: Menu Terlaris Filter ──
        $donutDays = (int) $request->input('donut_days', 30);
        if (!in_array($donutDays, [7, 30, 365])) {
            $donutDays = 30;
        }
        $donutStart = Carbon::now()->subDays($donutDays - 1)->startOfDay();
        $donutEnd   = Carbon::now()->endOfDay();

        // ── Donut Chart: Menu Terlaris stall ini ──
        $topMenus = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [$donutStart, $donutEnd]))
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

        // Fallback jika belum ada transaksi
        if (empty($menuData)) {
            $stallMenus = Menu::where('stall_id', $stallId)->take(3)->get();
            $dummyPercs = [45, 30, 25];
            foreach ($stallMenus as $idx => $m) {
                $menuData[] = ['name' => $m->name, 'qty' => $dummyPercs[$idx] ?? 10];
                $totalSold  += $dummyPercs[$idx] ?? 10;
            }
            if (empty($menuData)) {
                $menuData = [
                    ['name' => 'Menu Utama', 'qty' => 45],
                    ['name' => 'Menu Kedua', 'qty' => 30],
                    ['name' => 'Lainnya',    'qty' => 25],
                ];
                $totalSold = 100;
            }
        }

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

        // ── Tren Pendapatan Filter ──
        $trendDays = (int) $request->input('trend_days');
        if (!in_array($trendDays, [7, 30, 365])) {
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
        }

        if ($trendDays === 365) {
            $revenueRows = OrderItem::select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m") as order_month'),
                    DB::raw('SUM(order_items.total_price) as monthly_total')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
                ->where('menus.stall_id', $stallId)
                ->where('orders.payment_status', 'paid')
                ->whereBetween('orders.created_at', [
                    Carbon::now()->subMonths(11)->startOfMonth(),
                    Carbon::now()->endOfDay(),
                ])
                ->groupBy('order_month')
                ->pluck('monthly_total', 'order_month')
                ->toArray();

            $revenueData = [];
            for ($i = 11; $i >= 0; $i--) {
                $monthObj = Carbon::now()->subMonths($i);
                $key = $monthObj->format('Y-m');
                $revenueData[] = [
                    'day'    => $monthObj->translatedFormat('M y'),
                    'amount' => (float) ($revenueRows[$key] ?? 0),
                ];
            }
        } else {
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


        if ($trendDays === 7) {
            $trendLabel = '7 Hari Terakhir';
        } elseif ($trendDays === 30) {
            $trendLabel = '30 Hari Terakhir';
        } else {
            $trendLabel = '12 Bulan Terakhir';
        }

        return view('staff.stall.dashboard', compact(
            'stall', 'totalOrders', 'totalRevenue', 'incomingOrdersCount',
            'totalMenus', 'availableMenus', 'menuData', 'totalSold', 'completedOrders',
            'points', 'linePath', 'areaPath', 'highestIdx', 'trendLabel', 'kpiDays',
            'trendDays', 'donutDays'
        ));
    }

    public function salesReport(Request $request)
    {
        $stall = $this->getActiveStall();
        if (!$stall) {
            abort(404, 'Stall tidak ditemukan.');
        }
        $stallId = $stall->stall_id;

        $timeframe = $request->input('timeframe', 'today');
        if (!in_array($timeframe, ['today', '7d', '30d', '12m'])) {
            $timeframe = 'today';
        }

        $timeframeLabels = [
            'today' => 'Hari Ini',
            '7d'    => '7 Hari Terakhir',
            '30d'   => '30 Hari Terakhir',
            '12m'   => '12 Bulan Terakhir',
        ];
        $timeframeLabel = $timeframeLabels[$timeframe];

        $startDate = match ($timeframe) {
            'today' => Carbon::today(),
            '7d'    => Carbon::now()->subDays(6)->startOfDay(),
            '30d'   => Carbon::now()->subDays(29)->startOfDay(),
            '12m'   => Carbon::now()->subMonths(11)->startOfMonth(),
        };
        $endDate = Carbon::now()->endOfDay();

        // ── 1. Total Pendapatan stall ini (paid order items) dalam periode ──
        $totalRevenue = OrderItem::whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate]))
            ->sum('total_price');

        // ── 2. Total Kuantitas Menu Terjual ──
        $totalItemsSold = (int) OrderItem::whereHas('menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate]))
            ->sum('quantity');

        // ── 3. Total Transaksi (jumlah order paid unik yang berisi item stall ini) ──
        $totalTransactions = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
            ->count();

        // ── 4. Rata-rata Nilai Pesanan ──
        $averageOrderValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // ── 5. Dine In vs Take Away counts ──
        $dineInCount = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereNotNull('table_id')
            ->count();

        $takeawayCount = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
            ->whereNull('table_id')
            ->count();

        $totalStats = $dineInCount + $takeawayCount;
        $dineInPercentage = $totalStats > 0 ? round(($dineInCount / $totalStats) * 100) : 0;
        $takeawayPercentage = $totalStats > 0 ? round(($takeawayCount / $totalStats) * 100) : 0;

        // ── 6. Top Seller Menus (Makanan yang Banyak Dibeli) ──
        $topMenus = OrderItem::select(
                'order_items.menu_id',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.total_price) as total_rev')
            )
            ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('menus.stall_id', $stallId)
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->get();

        // ── 7. Pesanan Selesai (Riwayat Transaksi paid order yang berisi menu stall ini) ──
        $completedOrders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('orderItems.menu', fn($q) => $q->where('stall_id', $stallId))
            ->with([
                'orderItems' => fn($q) => $q
                    ->whereHas('menu', fn($m) => $m->where('stall_id', $stallId))
                    ->with('menu'),
                'table',
            ])
            ->orderByDesc('created_at')
            ->get();

        // ── 8. Tren Pendapatan (Line Chart) ──
        $points = [];
        if ($timeframe === 'today') {
            $hourlyRevenue = OrderItem::select(
                    DB::raw('HOUR(orders.created_at) as order_hour'),
                    DB::raw('SUM(order_items.total_price) as hourly_total')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
                ->where('menus.stall_id', $stallId)
                ->where('orders.payment_status', 'paid')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->groupBy('order_hour')
                ->pluck('hourly_total', 'order_hour')
                ->toArray();

            for ($h = 0; $h < 24; $h++) {
                $points[] = [
                    'label'     => sprintf('%02d:00', $h),
                    'amount'    => (float) ($hourlyRevenue[$h] ?? 0),
                    'full_date' => "Jam " . sprintf('%02d:00', $h),
                ];
            }
        } elseif ($timeframe === '12m') {
            $monthlyRevenue = OrderItem::select(
                    DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m") as order_month'),
                    DB::raw('SUM(order_items.total_price) as monthly_total')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
                ->where('menus.stall_id', $stallId)
                ->where('orders.payment_status', 'paid')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->groupBy('order_month')
                ->pluck('monthly_total', 'order_month')
                ->toArray();

            for ($i = 11; $i >= 0; $i--) {
                $monthObj = Carbon::now()->subMonths($i);
                $key = $monthObj->format('Y-m');
                $points[] = [
                    'label'     => $monthObj->translatedFormat('M y'),
                    'amount'    => (float) ($monthlyRevenue[$key] ?? 0),
                    'full_date' => $monthObj->translatedFormat('F Y'),
                ];
            }
        } else {
            $daysCount = $timeframe === '7d' ? 7 : 30;
            $dailyRevenue = OrderItem::select(
                    DB::raw('DATE(orders.created_at) as order_date'),
                    DB::raw('SUM(order_items.total_price) as daily_total')
                )
                ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->join('menus',  'order_items.menu_id',  '=', 'menus.menu_id')
                ->where('menus.stall_id', $stallId)
                ->where('orders.payment_status', 'paid')
                ->whereBetween('orders.created_at', [
                    Carbon::now()->subDays($daysCount - 1)->startOfDay(),
                    Carbon::now()->endOfDay(),
                ])
                ->groupBy('order_date')
                ->pluck('daily_total', 'order_date')
                ->toArray();

            for ($i = $daysCount - 1; $i >= 0; $i--) {
                $dateObj = Carbon::now()->subDays($i);
                $key = $dateObj->toDateString();
                $points[] = [
                    'label'     => $daysCount === 7 ? $dateObj->translatedFormat('D') : $dateObj->format('d/m'),
                    'amount'    => (float) ($dailyRevenue[$key] ?? 0),
                    'full_date' => $dateObj->translatedFormat('d F Y'),
                ];
            }
        }

        return view('staff.stall.sales-report', compact(
            'stall', 'timeframe', 'timeframeLabel', 'totalRevenue', 'totalItemsSold',
            'averageOrderValue', 'totalTransactions', 'dineInCount', 'takeawayCount',
            'dineInPercentage', 'takeawayPercentage', 'topMenus', 'completedOrders', 'points'
        ));
    }

    public function exportSalesReport(Request $request)
    {
        return redirect()->route('stall.sales-report')->with('error', 'Ekspor ke Excel telah dinonaktifkan.');
    }

    public function pesananMasuk(Request $request)
    {
        $stall = $this->getActiveStall();
        if (!$stall) {
            abort(404, 'Stall tidak ditemukan. Silakan tambahkan data stall di database.');
        }
        $stallId = $stall->stall_id;

        // Ambil order aktif (is_completed = false) ATAU order selesai hari ini (is_completed = true & created_at >= Carbon::today())
        $orders = Order::where(function ($query) {
                $query->where('is_completed', false)
                      ->orWhere(function ($q) {
                          $q->where('is_completed', true)
                            ->where('created_at', '>=', Carbon::today());
                      });
            })
            ->whereNotIn('payment_status', ['cancelled'])
            ->whereHas('orderItems.menu', function ($q) use ($stallId) {
                $q->where('stall_id', $stallId);
            })
            ->with([
                'orderItems' => fn($q) => $q->whereHas('menu', fn($m) => $m->where('stall_id', $stallId))->with('menu'),
                'table',
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($orders as $order) {
            $stallItems   = $order->orderItems;
            $order->stall_total_price = $stallItems->sum('total_price');
            $itemStatuses = $stallItems->pluck('status');

            if ($order->is_completed) {
                $order->stall_status = 'SELESAI';
            } elseif ($itemStatuses->contains('preparing')) {
                $order->stall_status = 'DIMASAK';
            } elseif ($itemStatuses->isNotEmpty() && $itemStatuses->every(fn($s) => $s === 'served')) {
                $order->stall_status = 'SELESAI';
            } else {
                $cached = Cache::get("stall_{$stallId}_order_{$order->order_id}_status");
                $order->stall_status = $cached ? strtoupper($cached) : 'MENUNGGU';
            }
        }

        $semuaCount    = $orders->count();
        $menungguCount = $orders->filter(fn($o) => $o->stall_status === 'MENUNGGU')->count();
        $dimasakCount  = $orders->filter(fn($o) => $o->stall_status === 'DIMASAK')->count();
        $selesaiCount  = $orders->filter(fn($o) => $o->stall_status === 'SELESAI')->count();

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
        } elseif ($filter === 'selesai') {
            $orders = $orders->filter(fn($o) => $o->stall_status === 'SELESAI')->values();
        }

        return view('staff.stall.pesananmasuk', compact(
            'stall', 'orders', 'semuaCount', 'menungguCount', 'dimasakCount', 'selesaiCount', 'filter', 'search'
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
