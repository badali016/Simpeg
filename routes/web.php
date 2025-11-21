<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes for Jabatan
Route::resource('jabatan', JabatanController::class);
Route::resource('pegawai', PegawaiController::class);
// Dashboards
Route::get('admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', \App\Http\Middleware\IsAdmin::class])
    ->name('admin.dashboard');
Route::get('pegawai/dashboard', [DashboardController::class, 'pegawai'])->name('pegawai.dashboard');

// Auth routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::get('register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
