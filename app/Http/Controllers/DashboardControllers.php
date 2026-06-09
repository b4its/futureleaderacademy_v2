<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kelas;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class DashboardControllers extends Controller
{
    public function index()
    {
        // Ambil 3 artikel terbaru untuk section artikel di welcome page
        $artikels = Artikel::with('kategoriArtikel')
            ->latest()
            ->limit(3)
            ->get();

        $totalArtikels = Artikel::count();

        // Ambil semua kelas untuk section program
        $kelasList = Kelas::all();

        // Ambil testimoni (tampilkan semua data testimoni)
        $testimonis = Testimoni::latest()->get();

        return view('welcome', compact('artikels', 'totalArtikels', 'kelasList', 'testimonis'));
    }
}
