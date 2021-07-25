<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudExampleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestingController;
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
    Route::get('crud-examples/import-excel-example', [CrudExampleController::class, 'importExcelExample'])->name('crud-examples.import-excel-example');
    Route::post('crud-examples/import-excel', [CrudExampleController::class, 'importExcel'])->name('crud-examples.import-excel');
    Route::resource('crud-examples', CrudExampleController::class);

    Route::get('mahasiswas/import-excel-example', [\App\Http\Controllers\MahasiswaController::class, 'importExcelExample'])->name('mahasiswas.import-excel-example');
Route::post('mahasiswas/import-excel', [\App\Http\Controllers\MahasiswaController::class, 'importExcel'])->name('mahasiswas.import-excel');
Route::resource('mahasiswas', \App\Http\Controllers\MahasiswaController::class);

    Route::get('testing/datatable', [TestingController::class, 'datatable']);
    Route::get('testing/send-email', [TestingController::class, 'sendEmail']);
    Route::get('testing/modal', [TestingController::class, 'modal']);
});

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('verification', [AuthController::class, 'verificationForm'])->name('verification');
    Route::post('verification', [AuthController::class, 'verification']);
    Route::get('verify/{token}', [AuthController::class, 'verify'])->name('verify');
    Route::get('register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    Route::get('forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset-password');
    Route::post('reset-password/{token}', [AuthController::class, 'resetPassword']);
});
