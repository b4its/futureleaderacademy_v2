<?php

use App\Http\Controllers\Accounts\LoginControllers;
use App\Http\Controllers\Pembelajaran\PembelajaranControllers;
use App\Http\Controllers\Pembelajaran\Pengajar\PembelajaranPengajarControllers;
use App\Http\Controllers\Pembelajaran\StatistikPembelajaranControllers;
use App\Http\Controllers\Pembelajaran\TryoutPembelajaranControllers;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::prefix('accounts')->group(function () {
    Route::view('auth', 'accounts.auth')->name('auth.index');
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
            
            // --- ROUTE BARU UNTUK EDIT & DELETE ---
            Route::get('{id}/edit', 'edit')->name('tes.edit');
            Route::post('{id}/update', 'update')->name('tes.update');
            Route::delete('{id}', 'destroy')->name('tes.destroy');
        });
    });
});

Route::prefix('artikel')->group(function () {
    Route::view('/', 'artikel.index_artikel')->name('artikel.index');
    Route::view('view', 'artikel.view_artikel')->name('artikel.view.index');
});