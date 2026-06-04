<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Table;
use App\Models\Stall;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show Dine In page with optional scanned table.
     */
    public function showDineIn(Request $request)
    {
        $tableNumber = $request->query('table');
        if ($tableNumber) {
            // Save scanned table in session for consistency
            session(['scanned_table' => $tableNumber]);
        } else if (session()->has('scanned_table')) {
            $tableNumber = session('scanned_table');
        } else if (session()->has('reservation')) {
            $tableNumber = session('reservation.table_number');
        }

        $table = null;
        if ($tableNumber) {
            // Check if there is an active reservation matching the table
            if (session()->has('reservation') && session('reservation.table_number') == $tableNumber) {
                $table = Table::where('table_number', $tableNumber)->first();
            } else {
                // Otherwise only allow if it's available or already scanned
                $table = Table::where('table_number', $tableNumber)->first();
                if ($table && !$table->is_available && session('scanned_table') != $tableNumber) {
                    $table = null;
                    session()->forget('scanned_table');
                }
            }
        }

        // 1. Ambil ID menu terpopuler dalam 7 hari terakhir
        $startOfWeek = now()->subDays(7);
        $weeklyPopularMenuIds = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.created_at', '>=', $startOfWeek)
            ->select('order_items.menu_id', \DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->pluck('order_items.menu_id')
            ->toArray();

        // Fallback jika belum ada data pesanan dalam 7 hari terakhir
        if (empty($weeklyPopularMenuIds)) {
            $weeklyPopularMenuIds = OrderItem::select('menu_id', \DB::raw('SUM(quantity) as total_qty'))
                ->groupBy('menu_id')
                ->orderByDesc('total_qty')
                ->limit(10)
                ->pluck('menu_id')
                ->toArray();
        }

        // 2. Ambil semua stall beserta menu-menunya
        $stalls = Stall::with('menus')->get();

        // 3. Kelompokkan menu untuk setiap Stall ke dalam 3 kategori di memori
        foreach ($stalls as $stall) {
            $menus = $stall->menus;

            // Kategori 1: Pilihan Chef
            $stall->chefRecommendations = $menus->filter(function ($menu) {
                return $menu->is_chef_recommendation && $menu->is_available;
            });

            // Kategori 2: Rekomendasi Terpopuler Minggu Ini
            $stall->weeklyRecommendations = $menus->filter(function ($menu) use ($weeklyPopularMenuIds) {
                return !$menu->is_chef_recommendation && $menu->is_available && in_array($menu->menu_id, $weeklyPopularMenuIds);
            })->sortBy(function ($menu) use ($weeklyPopularMenuIds) {
                return array_search($menu->menu_id, $weeklyPopularMenuIds);
            })->take(3); // batasi maksimal 3 menu terpopuler per stall

            // Kategori 3: Menu Regulair (Lainnya)
            $featuredIds = $stall->chefRecommendations->pluck('menu_id')
                ->merge($stall->weeklyRecommendations->pluck('menu_id'))
                ->toArray();

            $stall->regularMenus = $menus->filter(function ($menu) use ($featuredIds) {
                return $menu->is_available && !in_array($menu->menu_id, $featuredIds);
            });
        }

        $tables = Table::where('is_available', true)->orderBy('table_number')->get();
        return view('dinein', compact('stalls', 'table', 'tables'));
    }

    public function showCheckout(Request $request)
    {
        $tableNumber = $request->query('table');
        if (!$tableNumber && session()->has('scanned_table')) {
            $tableNumber = session('scanned_table');
        }
        if (!$tableNumber && session()->has('reservation')) {
            $tableNumber = session('reservation.table_number');
        }

        $table = null;
        if ($tableNumber) {
            $table = Table::where('table_number', $tableNumber)->first();
        }
        $tables = Table::where('is_available', true)->orderBy('table_number')->get();
        return view('checkout', compact('table', 'tables'));
    }

    /**
     * Process checkout for dine-in and reservation customers.
     */
    public function checkoutDineIn(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'table_number' => 'required|string',
            'payment_method' => 'required|string',
            'cart_items' => 'required|array',
            'cart_items.*.name' => 'required|string',
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['phone_number' => $request->phone_number],
            ['name' => $request->name]
        );
        if ($request->filled('email') && !$customer->email) {
            $customer->email = $request->email;
            $customer->save();
        }

        // Find table
        $table = Table::where('table_number', $request->table_number)->first();
        if (!$table) {
            return response()->json(['error' => 'Nomor meja tidak valid.'], 422);
        }

        // Calculate total
        $subtotal = 0;
        $itemsData = [];

        foreach ($request->cart_items as $item) {
            $menu = Menu::where('name', $item['name'])->first();
            if (!$menu) {
                return response()->json(['error' => "Menu '{$item['name']}' tidak ditemukan."], 422);
            }
            $subtotal += $menu->price * $item['quantity'];
            $itemsData[] = [
                'menu' => $menu,
                'quantity' => $item['quantity'],
                'notes' => $item['notes'] ?? null
            ];
        }

        // No tax for dine-in and reservation orders
        $totalPrice = $subtotal;

        // Check if there is a reservation in session
        $isReservation = session()->has('reservation');
        $reservation = session('reservation');

        $orderType = 'dine_in';
        $orderPrefix = 'DP-DIN-';
        $resDate = null;
        $resTime = null;
        $resPeople = null;

        if ($isReservation) {
            $orderType = 'reservation';
            $orderPrefix = 'DP-RES-';
            $resDate = $reservation['date'];
            $resTime = $reservation['time'];
            $resPeople = $reservation['number_of_people'];
        }

        // Create order
        $orderNumber = $orderPrefix . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $order = Order::create([
            'customer_id' => $customer->customer_id,
            'order_number' => $orderNumber,
            'order_type' => $orderType,
            'table_id' => $table->table_id,
            'reservation_date' => $resDate,
            'reservation_time' => $resTime,
            'number_of_people' => $resPeople,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Create order items
        foreach ($itemsData as $data) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'menu_id' => $data['menu']->menu_id,
                'quantity' => $data['quantity'],
                'price_each_at_transaction' => $data['menu']->price,
                'total_price' => $data['menu']->price * $data['quantity'],
                'notes' => $data['notes'],
                'status' => 'preparing',
            ]);
        }

        if ($isReservation) {
            session()->forget('reservation');
        }
        session()->forget('scanned_table');

        // Mark table as unavailable after order is placed
        $table->is_available = false;
        $table->save();

        return response()->json([
            'success' => true,
            'redirect_url' => route('order.payment', $order->order_number) . '?success=true',
            'order_number' => $order->order_number,
            'table_number' => $table->table_number,
        ]);
    }

    /**
     * Store reservation details in the session and redirect.
     */
    public function storeReservationSession(Request $request)
    {
        $maxDate = now()->addMonth()->format('Y-m-d');

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'number_of_people' => 'required|integer|min:1',
            'date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . $maxDate],
            'time' => 'required|string',
            'table_number' => 'required|string',
        ]);

        // Mark the selected table as unavailable (reserved)
        $table = Table::where('table_number', $request->table_number)->first();
        if ($table) {
            $table->is_available = false;
            $table->save();
        }

        session([
            'reservation' => [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'number_of_people' => $request->number_of_people,
                'date' => $request->date,
                'time' => $request->time,
                'table_number' => $request->table_number,
            ]
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('dinein')
        ]);
    }

    /**
     * Clear active reservation session.
     */
    public function clearReservationSession()
    {
        // Re-enable table availability when reservation is cancelled
        $tableNumber = session('reservation.table_number');
        session()->forget('reservation');
        session()->forget('scanned_table');

        if ($tableNumber) {
            $table = Table::where('table_number', $tableNumber)->first();
            if ($table) {
                $table->is_available = true;
                $table->save();
            }
        }

        return redirect()->back()->with('success', 'Reservasi dibatalkan.');
    }

    /**
     * Show payment page for the order.
     */
    public function showPayment($order_number)
    {
        $order = Order::with(['customer', 'table', 'orderItems.menu'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('order-payment', compact('order'));
    }

    /**
     * Upload proof of payment.
     */
    public function uploadPaymentProof(Request $request, $order_number)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::where('order_number', $order_number)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $dir = public_path('uploads/proofs');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $filename = time() . '_' . $order_number . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);

            $order->payment_proof = 'uploads/proofs/' . $filename;
            $order->save();
        }

        return redirect()->route('order.payment', $order->order_number)
            ->with('upload_success', true);
    }

    /**
     * Display admin order dashboard.
     */
    public function adminDashboard()
    {
        $orders = Order::with(['customer', 'table', 'orderItems.menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        $tables = Table::all();

        return view('admin.dashboard', compact('orders', 'tables'));
    }

    /**
     * Admin validate payment.
     */
    public function adminValidatePayment($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->validated_by = Auth::guard('admin')->user()->admin_account_id;
        $order->validated_at = now();
        $order->save();

        return back()->with('success', 'Pembayaran order ' . $order->order_number . ' telah divalidasi.');
    }

    /**
     * Admin cancel order.
     */
    public function adminCancelOrder($order_id)
    {
        $order = Order::with('table')->findOrFail($order_id);
        $order->payment_status = 'cancelled';
        $order->save();

        if ($order->table) {
            $order->table->is_available = true;
            $order->table->save();
        }

        return back()->with('success', 'Order ' . $order->order_number . ' telah dibatalkan.');
    }
}
