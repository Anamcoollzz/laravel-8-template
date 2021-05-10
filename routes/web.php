<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\ViewShare;
use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth'
    ViewShare::class,
])->group(function () {

    # DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    # SETTINGS
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
