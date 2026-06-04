<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\KelolaUserController;
use App\Http\Controllers\Superadmin\KelolaUndanganController;


use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    });

    Route::middleware(['role:reseller'])->prefix('reseller')->name('reseller.')->group(function () {
        Route::get('/dashboard', function () {
            return view('reseller.dashboard');
        })->name('dashboard');
    });

    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard'); 
    });

});

Route::get('/undangan/{slug}', [InvitationController::class, 'show'])
    ->name('invitation.show');

require __DIR__.'/auth.php';
