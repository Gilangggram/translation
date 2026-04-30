<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StallAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/delivery', function () {
    return view('delivery');
})->name('delivery');

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
