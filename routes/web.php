<?php

use App\Http\Controllers\Accounts\LoginControllers;
use App\Http\Controllers\Accounts\ProfileControllers;
use App\Http\Controllers\Accounts\RegisterControllers;
use App\Http\Controllers\Artikel\ArtikelControllers;
use App\Http\Controllers\DashboardControllers;
use App\Http\Controllers\Pembelajaran\PembelajaranControllers;
use App\Http\Controllers\Pembelajaran\PaketTryoutPembelajaranControllers;
use App\Http\Controllers\Pembelajaran\Pengajar\PaketPengajarControllers;
use App\Http\Controllers\Pembelajaran\Pengajar\PembelajaranPengajarControllers;
use App\Http\Controllers\Pembelajaran\StatistikPembelajaranControllers;
use App\Http\Controllers\Pembelajaran\TryoutPembelajaranControllers;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [DashboardControllers::class, 'index'])->name('welcome');

/*
 | Penyaji file media (fallback).
 |
 | Di sebagian hosting, document root situs (mis. public_html) BERBEDA dengan
 | folder "public" milik Laravel (mis. public_html/public). Akibatnya file yang
 | tersimpan di public_path('media/...') tidak dapat diakses langsung lewat URL
 | dan menghasilkan 404. Route ini melayani file media langsung dari
 | public_path('media') sehingga gambar tetap tampil tanpa bergantung pada
 | konfigurasi document root. Di lokal, web server menyajikan file fisik lebih
 | dulu sehingga route ini tidak terpakai (tanpa regresi).
 */
Route::get('media/{path}', function (string $path) {
    $base = realpath(public_path('media'));
    $full = realpath(public_path('media/' . $path));

    abort_if($base === false || $full === false, 404);
    abort_unless(str_starts_with($full, $base . DIRECTORY_SEPARATOR), 404); // cegah path traversal
    abort_unless(is_file($full), 404);

    return response()->file($full);
})->where('path', '.*')->name('media.serve');

// Auth Routes (hanya guest)
Route::prefix('accounts')->middleware('guest')->group(function () {
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

// Artikel (public)
Route::prefix('artikel')->group(function () {
    Route::get('/', [ArtikelControllers::class, 'index'])->name('artikel.index');
    Route::get('/{id}', [ArtikelControllers::class, 'show'])->name('artikel.show');
});

// ==================== PEMBELAJARAN (AUTH REQUIRED) ====================
Route::prefix('pembelajaran')->middleware('auth')->group(function () {
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

    // Paket Tes (gabungan beberapa tes_pengetahuan)
    Route::controller(PaketTryoutPembelajaranControllers::class)->group(function () {
        Route::get('paket', 'index')->name('pembelajaran.paket.index');
        Route::get('paket/{id}', 'show')->name('pembelajaran.paket.show');
        Route::post('paket/{id}', 'store')->name('pembelajaran.paket.store');
        Route::get('paket/{id}/hasil/{attemptId}', 'hasil')->name('pembelajaran.paket.hasil');
    });

    // Sub-domain Pengajar (hanya admin & pengajar)
    Route::prefix('pengajar')->name('pembelajaran.pengajar.')->middleware('role:admin,pengajar')->group(function () {
        Route::controller(PembelajaranPengajarControllers::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('kelola', 'kelola')->name('kelola');
            Route::get('progress', 'progress')->name('progress');
            Route::get('progress/{userId}/detail', 'progressDetail')->name('progress.detail');

            Route::get('create', 'create')->name('tes.create');
            Route::post('store', 'store')->name('tes.store');

            Route::get('{id}/edit', 'edit')->name('tes.edit');
            Route::post('{id}/update', 'update')->name('tes.update');

            // Edit Soal (relasi tes_pengetahuan <-> soal)
            Route::get('{id}/soal', 'getSoal')->name('tes.soal');
            Route::post('{id}/soal', 'updateSoal')->name('tes.soal.update');

            Route::delete('{id}', 'destroy')->name('tes.destroy');
        });

        // Kelola Paket Tes (gabungan beberapa tes) - admin & pengajar
        Route::controller(PaketPengajarControllers::class)->group(function () {
            Route::get('paket', 'index')->name('paket.index');
            Route::get('paket/create', 'create')->name('paket.create');
            Route::post('paket', 'store')->name('paket.store');
            Route::get('paket/{id}/edit', 'edit')->name('paket.edit');
            Route::post('paket/{id}/update', 'update')->name('paket.update');
            Route::delete('paket/{id}', 'destroy')->name('paket.destroy');
        });
    });
});
