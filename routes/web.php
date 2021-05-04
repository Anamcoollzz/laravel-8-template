<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(function () {

# DASHBOARD
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

// });
