<?php

use Illuminate\Support\Facades\Route;

Route::controller(AdminAuthController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.post');
    Route::post('/admin/logout', 'logout')->name('admin.logout');
});
