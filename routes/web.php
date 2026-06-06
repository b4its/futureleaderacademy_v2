<?php

use App\Http\Controllers\Accounts\LoginControllers;
use App\Http\Controllers\Pembelajaran\PembelajaranControllers;
use App\Http\Controllers\Pembelajaran\StatistikPembelajaranControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::prefix('accounts')->group(function () {
    Route::view('auth', 'accounts.auth')->name('auth.index');
});
Route::prefix('pembelajaran')->group(function () {
    Route::view('/', 'pembelajaran.index_pembelajaran')->name('pembelajaran.index');
    Route::controller(StatistikPembelajaranControllers::class)->group(function () {
        Route::get('statistik', 'index')->name('pembelajaran.statistik.index');
    });
        Route::view('tryout', 'pembelajaran.tryoutku_pembelajaran')->name('pembelajaran.tryout.index');
        Route::view('cat', 'pembelajaran.cat_pembelajaran')->name('pembelajaran.cat.index');
});
Route::prefix('artikel')->group(function () {
        Route::view('/', 'artikel.index_artikel')->name('artikel.index');
        Route::view('view', 'artikel.view_artikel')->name('artikel.view.index');
});

