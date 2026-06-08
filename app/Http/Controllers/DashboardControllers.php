<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kelas;
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

        return view('welcome', compact('artikels', 'totalArtikels', 'kelasList'));
    }
}
