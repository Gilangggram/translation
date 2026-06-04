<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StallAuthController;
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
