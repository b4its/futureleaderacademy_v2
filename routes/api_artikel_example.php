<?php

/**
 * CONTOH API ROUTES UNTUK ARTIKEL
 * 
 * File ini adalah contoh routes API untuk artikel.
 * Jika Anda ingin menggunakan API, tambahkan routes ini ke routes/api.php
 */

use App\Http\Controllers\Artikel\ArtikelApiController;
use Illuminate\Support\Facades\Route;

// Public API (tidak perlu auth)
Route::prefix('artikel')->group(function () {
    // Get all articles
    Route::get('/', [ArtikelApiController::class, 'index']);
    
    // Get single article
    Route::get('/{id}', [ArtikelApiController::class, 'show']);
    
    // Get categories
    Route::get('/categories/list', [ArtikelApiController::class, 'categories']);
});

// Protected API (perlu auth - uncomment jika sudah ada auth)
/*
Route::middleware('auth:sanctum')->prefix('artikel')->group(function () {
    // Create article
    Route::post('/', [ArtikelApiController::class, 'store']);
    
    // Update article
    Route::put('/{id}', [ArtikelApiController::class, 'update']);
    Route::patch('/{id}', [ArtikelApiController::class, 'update']);
    
    // Delete article
    Route::delete('/{id}', [ArtikelApiController::class, 'destroy']);
});
*/

/**
 * CARA MENGGUNAKAN:
 * 
 * 1. Copy routes di atas ke routes/api.php
 * 2. Akses API melalui:
 *    - GET /api/artikel
 *    - GET /api/artikel/{id}
 *    - GET /api/artikel/categories/list
 *    - POST /api/artikel (jika sudah uncomment protected routes)
 *    - PUT /api/artikel/{id} (jika sudah uncomment protected routes)
 *    - DELETE /api/artikel/{id} (jika sudah uncomment protected routes)
 * 
 * CONTOH REQUEST:
 * 
 * GET /api/artikel?per_page=20&kategori_id=1
 * 
 * POST /api/artikel
 * Content-Type: multipart/form-data
 * Body:
 * {
 *   "kategori_artikel_id": 1,
 *   "title": "Judul Artikel",
 *   "description": "Konten artikel...",
 *   "gambar": [file]
 * }
 */
