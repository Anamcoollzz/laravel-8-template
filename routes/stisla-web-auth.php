<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CrudExampleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

# DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

# SETTINGS
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

# PROFILE
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('profile', [ProfileController::class, 'update']);
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

# DATATABLE
Route::view('datatable', 'stisla.examples.datatable.index')->name('datatable.index');

# FORM
Route::view('form', 'stisla.examples.form.index')->name('form.index');

# CHART JS
Route::view('chart-js', 'stisla.examples.chart-js.index')->name('chart-js.index');

# USER MANAGEMENT
Route::prefix('user-management')->as('user-management.')->group(function () {
    Route::resource('users', UserManagementController::class);

    # ROLES
    Route::get('roles/import-excel-example', [RoleController::class, 'importExcelExample'])->name('roles.import-excel-example');
    Route::post('roles/import-excel', [RoleController::class, 'importExcel'])->name('roles.import-excel');
    Route::resource('roles', RoleController::class);
});

# ACTIVITY LOGS
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
Route::get('activity-logs/print', [ActivityLogController::class, 'exportPrint'])->name('activity-logs.print');
Route::get('activity-logs/pdf', [ActivityLogController::class, 'pdf'])->name('activity-logs.pdf');
Route::get('activity-logs/csv', [ActivityLogController::class, 'csv'])->name('activity-logs.csv');
Route::get('activity-logs/json', [ActivityLogController::class, 'json'])->name('activity-logs.json');
Route::get('activity-logs/excel', [ActivityLogController::class, 'excel'])->name('activity-logs.excel');

# CONTOH CRUD
Route::get('crud-examples/pdf', [CrudExampleController::class, 'pdf'])->name('crud-examples.pdf');
Route::get('crud-examples/csv', [CrudExampleController::class, 'csv'])->name('crud-examples.csv');
Route::get('crud-examples/excel', [CrudExampleController::class, 'excel'])->name('crud-examples.excel');
Route::get('crud-examples/json', [CrudExampleController::class, 'json'])->name('crud-examples.json');
Route::get('crud-examples/import-excel-example', [CrudExampleController::class, 'importExcelExample'])->name('crud-examples.import-excel-example');
Route::post('crud-examples/import-excel', [CrudExampleController::class, 'importExcel'])->name('crud-examples.import-excel');
Route::resource('crud-examples', CrudExampleController::class);

Route::get('mahasiswas/import-excel-example', [\App\Http\Controllers\MahasiswaController::class, 'importExcelExample'])->name('mahasiswas.import-excel-example');
Route::post('mahasiswas/import-excel', [\App\Http\Controllers\MahasiswaController::class, 'importExcel'])->name('mahasiswas.import-excel');
Route::resource('mahasiswas', \App\Http\Controllers\MahasiswaController::class);

Route::get('testing/datatable', [TestingController::class, 'datatable']);
Route::get('testing/send-email', [TestingController::class, 'sendEmail']);
Route::get('testing/modal', [TestingController::class, 'modal']);
