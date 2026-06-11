<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // Tambahan

// SUPERADMIN
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboard;
use App\Http\Controllers\Superadmin\KelolaUserController;
use App\Http\Controllers\Superadmin\KelolaUndanganController;
use App\Http\Controllers\Superadmin\ThemeController;

// RESELLER
use App\Http\Controllers\Reseller\ResDashboardController;
use App\Http\Controllers\Reseller\ResKelolaUndanganController;
use App\Http\Controllers\Reseller\ResKelolaUserController;

// CUSTOMER
use App\Http\Controllers\Customer\CusDashboardController;
use App\Http\Controllers\Customer\CusKelolaUndanganController;

// GLOBAL
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// OTP
use App\Http\Controllers\Auth\RegisterOtpController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/themes', [HomeController::class, 'index'])->name('themes.index');
Route::get('/themes/{id}/preview', [HomeController::class, 'preview'])->name('themes.preview');
Route::get('/undangan/{slug}', [InvitationController::class, 'show'])->name('invitation.show');

Route::get('/builder/{invitation}', [BuilderController::class, 'index']);
Route::post('/builder/{invitation}/save', [BuilderController::class, 'save']);

// RUTE DASHBOARD DIPERBAIKI (Tidak lagi pakai function kosong)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // SUPERADMIN
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperadminDashboard::class, 'index'])->name('dashboard');
        Route::get('/kelola-user', [KelolaUserController::class, 'index'])->name('user.index');
        Route::post('/kelola-user', [KelolaUserController::class, 'store'])->name('user.store');
        Route::put('/kelola-user/{id}', [KelolaUserController::class, 'update'])->name('user.update');
        Route::delete('/kelola-user/{id}', [KelolaUserController::class, 'destroy'])->name('user.destroy');
        Route::get('kelola-undangan', [KelolaUndanganController::class, 'index'])->name('kelola-undangan.index');
        Route::get('kelola-undangan/create', [KelolaUndanganController::class, 'create'])->name('kelola-undangan.create');
        Route::post('kelola-undangan', [KelolaUndanganController::class, 'store'])->name('kelola-undangan.store');
        Route::get('kelola-undangan/{id}/edit', [KelolaUndanganController::class, 'edit'])->name('kelola-undangan.edit');
        Route::put('kelola-undangan/{id}', [KelolaUndanganController::class, 'update'])->name('kelola-undangan.update');
        Route::delete('kelola-undangan/{id}', [KelolaUndanganController::class, 'destroy'])->name('kelola-undangan.destroy');
        Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
        Route::post('themes', [ThemeController::class, 'store'])->name('themes.store');
        Route::put('themes/{id}', [ThemeController::class, 'update'])->name('themes.update');
        Route::delete('themes/{id}', [ThemeController::class, 'destroy'])->name('themes.destroy');
        Route::patch('themes/{id}/toggle', [ThemeController::class, 'toggleStatus'])->name('themes.toggle');
        Route::get('themes/{id}/preview', [ThemeController::class, 'preview'])->name('themes.preview');
    });

    // RESELLER
    Route::middleware(['role:reseller'])->prefix('reseller')->name('reseller.')->group(function () {
        Route::get('/dashboard', [ResDashboardController::class, 'index'])->name('dashboard');
        Route::get('/kelola-user', [ResKelolaUserController::class, 'index'])->name('user.index');
        Route::post('/kelola-user', [ResKelolaUserController::class, 'store'])->name('user.store');
        Route::put('/kelola-user/{id}', [ResKelolaUserController::class, 'update'])->name('user.update');
        Route::delete('/kelola-user/{id}', [ResKelolaUserController::class, 'destroy'])->name('user.destroy');
        Route::get('kelola-undangan', [ResKelolaUndanganController::class, 'index'])->name('kelola-undangan.index');
        Route::get('kelola-undangan/create', [ResKelolaUndanganController::class, 'create'])->name('kelola-undangan.create');
        Route::get('kelola-undangan/{id}/edit', [ResKelolaUndanganController::class, 'edit'])->name('kelola-undangan.edit');
        Route::post('kelola-undangan/save/{id?}', [ResKelolaUndanganController::class, 'save'])->name('kelola-undangan.save');
        Route::delete('kelola-undangan/{id}', [ResKelolaUndanganController::class, 'destroy'])->name('kelola-undangan.destroy');
        Route::post('kelola-undangan/{id}/toggle-status', [ResKelolaUndanganController::class, 'toggleStatus'])->name('kelola-undangan.toggle-status');
        Route::get('/themes/{id}/preview', [CusDashboardController::class, 'preview'])->name('themes.preview');
    });

    // CUSTOMER
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CusDashboardController::class, 'index'])->name('dashboard');
        Route::get('kelola-undangan', [CusKelolaUndanganController::class, 'index'])->name('customer.kelola-undangan.index'); // Nama route saya sesuaikan
        Route::get('kelola-undangan/create', [CusKelolaUndanganController::class, 'create'])->name('customer.kelola-undangan.create');
        Route::get('kelola-undangan/{id}/edit', [CusKelolaUndanganController::class, 'edit'])->name('customer.kelola-undangan.edit');
        Route::post('kelola-undangan/save/{id?}', [CusKelolaUndanganController::class, 'save'])->name('customer.kelola-undangan.save');
        Route::delete('kelola-undangan/{id}', [CusKelolaUndanganController::class, 'destroy'])->name('customer.kelola-undangan.destroy');
        Route::post('kelola-undangan/{id}/toggle-status', [CusKelolaUndanganController::class, 'toggleStatus'])->name('customer.kelola-undangan.toggle-status');
        Route::get('/themes/{id}/preview', [CusDashboardController::class, 'preview'])->name('customer.themes.preview');
    });
});

Route::middleware('guest')->group(function () {
    Route::post('/register/send-otp', [RegisterOtpController::class, 'send'])->name('register.send-otp');
    Route::post('/register/verify-otp', [RegisterOtpController::class, 'verify'])->name('register.verify-otp');
});

require __DIR__.'/auth.php';