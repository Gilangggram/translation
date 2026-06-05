<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StallAuthController;
use App\Http\Controllers\StallController;
use App\Livewire\Staff\Owner\Dashboard;
use App\Livewire\Staff\Owner\SalesReport;
use App\Livewire\Staff\Owner\StallsManagement\Index as StallsIndex;
use App\Livewire\Staff\Owner\StallsManagement\Create as StallsCreate;
use App\Livewire\Staff\Owner\StallsManagement\Detail as StallsDetail;
use App\Livewire\Staff\Owner\StallsManagement\Update as StallsUpdate;
use App\Livewire\Staff\Owner\AdminsManagement\Index as AdminsIndex;
use App\Livewire\Staff\Owner\AdminsManagement\Create as AdminsCreate;
use App\Livewire\Staff\Owner\AdminsManagement\Update as AdminsUpdate;
use Illuminate\Support\Facades\Route;

use App\Models\Stall;
use App\Models\Menu;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    $stalls = Stall::with('menus')->get();
    return view('landing', compact('stalls'));
})->name('landing');

Route::get('/delivery', function () {
    $stalls = Stall::with('menus')->get();
    $menus = Menu::with('stall')->get();
    return view('delivery', compact('stalls', 'menus'));
})->name('delivery');

Route::get('/reservation', function () {
    $tables = \App\Models\Table::orderBy(\DB::raw('CAST(table_number AS UNSIGNED)'))->get();
    return view('reservation', compact('tables'));
})->name('reservation');

Route::post('/reservation/confirm', [OrderController::class, 'storeReservationSession'])->name('reservation.confirm');
Route::post('/reservation/clear', [OrderController::class, 'clearReservationSession'])->name('reservation.clear');

Route::get('/dinein', [OrderController::class, 'showDineIn'])->name('dinein');
Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout');
Route::post('/dinein/checkout', [OrderController::class, 'checkoutDineIn'])->name('dinein.checkout');
Route::get('/order/payment/{order_number}', [OrderController::class, 'showPayment'])->name('order.payment');
Route::post('/order/payment/{order_number}/upload', [OrderController::class, 'uploadPaymentProof'])->name('order.payment.upload');

Route::middleware('guest:admin')->group(function () {
    Route::controller(AdminAuthController::class)->prefix('admin')->name('admin')->group(function () {
        Route::get('/login', 'index')->name('.login');
        Route::post('/login', 'login')->name('.login.post');
        Route::post('/logout', 'logout')->name('.logout');
    }); 
});

Route::middleware(['auth:admin', 'owner'])->prefix('owner')->name('owner')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('.dashboard');
    Route::get('/sales-report', SalesReport::class)->name('.sales-report');
    
    Route::prefix('stalls-management')->name('.stalls-management')->group(function () {
        Route::get('/index', StallsIndex::class)->name('.index');
        Route::get('/create', StallsCreate::class)->name('.create');
        Route::get('/detail/{stallId}', StallsDetail::class)->name('.detail');
        Route::get('/update/{stallId}', StallsUpdate::class)->name('.update');
    });

    Route::prefix('admins-managememt')->name('.admins-management')->group(function () {
        Route::get('/index', AdminsIndex::class)->name('.index');
        Route::get('/create', AdminsCreate::class)->name('.create');
        Route::get('/update/{adminId}', AdminsUpdate::class)->name('.update');
    });
});

Route::controller(StallAuthController::class)->prefix('stall')->name('stall')->group(function () {
    Route::get('/login', 'index')->name('.login');
    Route::post('/login', 'login')->name('.login.post');
    Route::post('/logout', 'logout')->name('.logout');
});

// ── Stall Panel (wajib login sebagai stall) ───────────────────────────────────
Route::middleware('auth:stall')->prefix('stall')->name('stall')->group(function () {
    Route::get('/dashboard', [StallController::class, 'dashboard'])->name('.dashboard');
    Route::get('/pesanan-masuk', [StallController::class, 'pesananMasuk'])->name('.pesananmasuk');
    Route::get('/sales-report', [StallController::class, 'salesReport'])->name('.sales-report');
    Route::get('/sales-report/export', [StallController::class, 'exportSalesReport'])->name('.sales-report.export');
    Route::post('/order/{order_id}/proses', [StallController::class, 'prosesOrder'])->name('.order.proses');
    Route::post('/order/{order_id}/siap-sajikan', [StallController::class, 'siapSajikanOrder'])->name('.order.siap-sajikan');
    Route::post('/toggle-status', [StallController::class, 'toggleStatus'])->name('.toggle-status');
});

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/orders/{id}/validate', [OrderController::class, 'adminValidatePayment'])->name('admin.orders.validate');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'adminCancelOrder'])->name('admin.orders.cancel');
    
    Route::get('/tables', [TableController::class, 'adminIndex'])->name('admin.tables');
    Route::post('/tables', [TableController::class, 'store'])->name('admin.tables.store');
    Route::post('/tables/{id}/toggle', [TableController::class, 'toggleAvailability'])->name('admin.tables.toggle');
    Route::delete('/tables/{id}', [TableController::class, 'destroy'])->name('admin.tables.destroy');
});
