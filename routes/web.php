<?php

use App\Http\Controllers\PegawaiSimgosController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboards
Route::get('admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', IsAdmin::class])
    ->name('admin.dashboard');
Route::get('pegawai/dashboard', [DashboardController::class, 'pegawai'])->name('pegawai.dashboard');

Route::get('pegawai', [PegawaiSimgosController::class, 'index']);
Route::get('pegawai/{id}', [PegawaiSimgosController::class, 'show']);
Route::get('pegawai-by-nip', [PegawaiSimgosController::class, 'findByNip']);

// Authentication routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::get('register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes for Pegawai management
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('admin/jabatan', JabatanController::class, ['as' => 'admin']);
    Route::resource('admin/pegawai', PegawaiController::class, ['as' => 'admin']);
    Route::resource('admin/users', \App\Http\Controllers\UserController::class, ['as' => 'admin']);
        // SIMGOS AJAX search for autocomplete
        Route::get('admin/simgos/search', [PegawaiSimgosController::class, 'search'])->name('admin.simgos.search');
        // Auto-create user from pegawai reference (local or simgos)
        Route::post('admin/pegawai/create-user', [PegawaiController::class, 'createUserFromRef'])->name('admin.pegawai.create_user');
    // Import from SIMGOS
    Route::post('admin/pegawai/import/{id}', [PegawaiController::class, 'import'])->name('admin.pegawai.import');
});

// Halaman Portal Depan (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Login yang sudah kita buat tadi (ganti nama viewnya jika beda)
Route::get('/login-simpeg', [AuthController::class, 'showLogin'])->name('login.simpeg');