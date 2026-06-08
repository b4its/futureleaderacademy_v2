<?php

namespace App\Http\Controllers\Artikel;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class ArtikelControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil kategori untuk filter
        $kategoriList = KategoriArtikel::withCount('artikel')->get();
        
        // Query artikel dengan relasi kategori
        $query = Artikel::with('kategoriArtikel')->latest();
        
        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != 'semua-kategori') {
            $query->whereHas('kategoriArtikel', function($q) use ($request) {
                $q->where('id', $request->kategori);
            });
        }
        
        // Pagination
        $artikels = $query->paginate(9);
        
        // Artikel featured (artikel terbaru pertama)
        $featuredArtikel = Artikel::with('kategoriArtikel')->latest()->first();
        
        return view('artikel.index_artikel', compact('artikels', 'kategoriList', 'featuredArtikel'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil artikel berdasarkan ID dengan relasi kategori
        $artikel = Artikel::with('kategoriArtikel')->findOrFail($id);
        
        // Artikel terkait dari kategori yang sama (maksimal 3)
        $relatedArtikels = Artikel::with('kategoriArtikel')
            ->where('kategori_artikel_id', $artikel->kategori_artikel_id)
            ->where('id', '!=', $artikel->id)
            ->latest()
            ->limit(3)
            ->get();
        
        return view('artikel.view_artikel', compact('artikel', 'relatedArtikels'));
    }
}
