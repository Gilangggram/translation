<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StallAuthController;
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

Route::controller(AdminAuthController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.post');
    Route::post('/admin/logout', 'logout')->name('admin.logout');
}); 

Route::controller(StallAuthController::class)->group(function () {
    Route::get('/stall/login', 'showLoginForm')->name('stall.login');
    Route::post('/stall/login', 'login')->name('stall.login.post');
    Route::post('/stall/logout', 'logout')->name('stall.logout');
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
