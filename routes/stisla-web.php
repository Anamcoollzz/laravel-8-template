<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

# AUTH
Route::get('auth/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/verification', [AuthController::class, 'verificationForm'])->name('verification');
Route::post('auth/verification', [AuthController::class, 'verification']);
Route::get('auth/verify/{token}', [AuthController::class, 'verify'])->name('verify');
Route::get('auth/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('auth/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forgot-password');
Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('auth/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset-password');
Route::post('auth/reset-password/{token}', [AuthController::class, 'resetPassword']);
