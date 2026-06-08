<?php

use App\Http\Controllers\Accounts\LoginControllers;
use App\Http\Controllers\Accounts\ProfileControllers;
use App\Http\Controllers\Accounts\RegisterControllers;
use App\Http\Controllers\Artikel\ArtikelControllers;
use App\Http\Controllers\DashboardControllers;
use App\Http\Controllers\Pembelajaran\PembelajaranControllers;
use App\Http\Controllers\Pembelajaran\Pengajar\PembelajaranPengajarControllers;
use App\Http\Controllers\Pembelajaran\StatistikPembelajaranControllers;
use App\Http\Controllers\Pembelajaran\TryoutPembelajaranControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardControllers::class, 'index'])->name('welcome');

// Auth Routes
Route::prefix('accounts')->group(function () {
    Route::get('auth', [LoginControllers::class, 'index'])->name('auth.index');
    Route::post('login', [LoginControllers::class, 'login'])->name('auth.login');
    Route::post('register', [RegisterControllers::class, 'register'])->name('auth.register');
});

// Logout (auth required)
Route::post('accounts/logout', [LoginControllers::class, 'logout'])->middleware('auth')->name('auth.logout');

// Profile (auth required)
Route::middleware('auth')->prefix('accounts')->group(function () {
    Route::get('profile', [ProfileControllers::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileControllers::class, 'update'])->name('profile.update');
});

Route::prefix('pembelajaran')->group(function () {
    Route::controller(PembelajaranControllers::class)->group(function () {
        Route::get('/', 'index')->name('pembelajaran.index');
    });

    Route::controller(StatistikPembelajaranControllers::class)->group(function () {
        Route::get('statistik', 'index')->name('pembelajaran.statistik.index');
    });

    Route::controller(TryoutPembelajaranControllers::class)->group(function () {
        Route::post('cat/validate-code', 'validateCode')->name('pembelajaran.cat.validate');
        Route::get('tryout', 'index')->name('pembelajaran.tryout.index');
        Route::get('cat/{id}', 'show')->name('pembelajaran.cat.show');
        Route::post('cat/{id}', 'store')->name('pembelajaran.cat.store');
    });

    // Sub-domain Pengajar
    Route::prefix('pengajar')->name('pembelajaran.pengajar.')->group(function () {
        Route::controller(PembelajaranPengajarControllers::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('tes.create');
            Route::post('store', 'store')->name('tes.store');

            Route::get('{id}/edit', 'edit')->name('tes.edit');
            Route::post('{id}/update', 'update')->name('tes.update');
            Route::delete('{id}', 'destroy')->name('tes.destroy');
        });
    });
});

Route::prefix('artikel')->group(function () {
    Route::get('/', [ArtikelControllers::class, 'index'])->name('artikel.index');
    Route::get('/{id}', [ArtikelControllers::class, 'show'])->name('artikel.show');
});
