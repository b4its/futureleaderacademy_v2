<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\KategoriTes;
use Illuminate\Http\Request;

class PembelajaranControllers extends Controller
{
    public function index()
    {
        // Ambil kategori & batasi relasi tes_pengetahuan maksimal 4 per kategori
        $kategoriTes = KategoriTes::with(['tesPengetahuan' => function ($query) {
            $query->where('status', 1)
                  ->withCount('hasilTes')
                  ->limit(4); 
        }])->get();

        return view('pembelajaran.index_pembelajaran', compact('kategoriTes'));
    }
}