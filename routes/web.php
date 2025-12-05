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

// Pegawai portal routes (for users linked to pegawai)
Route::middleware(['auth', \App\Http\Middleware\IsPegawai::class])->group(function () {
    Route::get('portal', [\App\Http\Controllers\PegawaiPortalController::class, 'dashboard'])->name('pegawai.portal');
    Route::get('portal/profile', [\App\Http\Controllers\PegawaiPortalController::class, 'profile'])->name('pegawai.profile');
    Route::get('portal/profile/edit', [\App\Http\Controllers\PegawaiPortalController::class, 'editContact'])->name('pegawai.profile.edit');
    Route::post('portal/profile', [\App\Http\Controllers\PegawaiPortalController::class, 'updateContact'])->name('pegawai.profile.update');

    // Attendance
    Route::get('portal/attendance', [\App\Http\Controllers\AttendanceController::class, 'showForm'])->name('pegawai.attendance.form');
    Route::post('portal/attendance', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('pegawai.attendance.store');
    Route::post('portal/attendance/correction', [\App\Http\Controllers\AttendanceController::class, 'requestCorrection'])->name('pegawai.attendance.correction');

    // Leave requests
    Route::get('portal/leave/create', [\App\Http\Controllers\LeaveController::class, 'create'])->name('pegawai.leave.create');
    Route::post('portal/leave', [\App\Http\Controllers\LeaveController::class, 'store'])->name('pegawai.leave.store');
    // Pegawai leave history (list + filters)
    Route::get('portal/leaves', [\App\Http\Controllers\LeaveController::class, 'index'])->name('pegawai.leaves.index');
});

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
        // Admin review: leave requests
        Route::get('admin/leaves', [\App\Http\Controllers\Admin\LeaveController::class, 'index'])->name('admin.leaves.index');
        Route::get('admin/leaves/{id}', [\App\Http\Controllers\Admin\LeaveController::class, 'show'])->name('admin.leaves.show');
        Route::post('admin/leaves/{id}/approve', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])->name('admin.leaves.approve');
        Route::post('admin/leaves/{id}/reject', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])->name('admin.leaves.reject');

        // Admin review: attendance corrections
        Route::get('admin/attendance/corrections', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::get('admin/attendance/{id}', [\App\Http\Controllers\Admin\AttendanceController::class, 'show'])->name('admin.attendance.show');
        Route::post('admin/attendance/{id}/resolve', [\App\Http\Controllers\Admin\AttendanceController::class, 'resolve'])->name('admin.attendance.resolve');
});

// Halaman Portal Depan (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Login yang sudah kita buat tadi (ganti nama viewnya jika beda)
Route::get('/login-simpeg', [AuthController::class, 'showLogin'])->name('login.simpeg');