<?php

use App\Http\Controllers\PegawaiSimgosController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;

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
Route::get('pegawai/dashboard', action: [DashboardController::class, 'pegawai'])->name('pegawai.dashboard');


Route::get('pegawai', [PegawaiSimgosController::class, 'index']);
Route::get('pegawai/{id}', [PegawaiSimgosController::class, 'show']);
Route::get('pegawai-by-nip', [PegawaiSimgosController::class, 'findByNip']);