<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudExampleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\ViewShare;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    ViewShare::class,
])->group(function () {

    # DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    # SETTINGS
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    # PROFILE
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    # DATATABLE
    Route::view('datatable', 'datatable.index')->name('datatable.index');

    # FORM
    Route::view('form', 'form.index')->name('form.index');

    # USER MANAGEMENT
    Route::prefix('user-management')->as('user-management.')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::resource('roles', RoleController::class);
    });

    # CONTOH CRUD
    Route::resource('crud-examples', CrudExampleController::class);

    Route::resource('mahasiswas', \App\Http\Controllers\MahasiswaController::class);
});

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
