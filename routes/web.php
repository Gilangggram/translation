<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StallAuthController;
use App\Livewire\Staff\Owner\Dashboard;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:admin')->group(function () {
    Route::controller(AdminAuthController::class)->prefix('admin')->name('admin')->group(function () {
        Route::get('/login', 'index')->name('.login');
        Route::post('/login', 'login')->name('.login.post');
        Route::post('/logout', 'logout')->name('.logout');
    }); 
});

Route::middleware(['auth:admin', 'owner'])->prefix('owner')->name('owner')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('.dashboard');
}); 

Route::controller(StallAuthController::class)->prefix('stall')->name('stall')->group(function () {
    Route::get('/login', 'index')->name('.login');
    Route::post('/login', 'login')->name('.login.post');
    Route::post('/logout', 'logout')->name('.logout');
});
