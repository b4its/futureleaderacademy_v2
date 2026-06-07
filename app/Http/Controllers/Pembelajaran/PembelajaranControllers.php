<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\KategoriTes;
use App\Models\TesPengetahuan;
use Illuminate\Http\Request;

class PembelajaranControllers extends Controller
{
    //
public function index()
    {
        // Ambil semua kategori beserta tes pengetahuan yang aktif (status = 1)
        // Gunakan withCount('hasilTes') untuk mendapatkan kolom 'hasil_tes_count' sebagai data 'plays'
        $kategoriTes = KategoriTes::with(['tesPengetahuan' => function ($query) {
            $query->where('status', 0)->withCount('hasilTes');
        }])->get();

        return view('pembelajaran.index_pembelajaran', compact('kategoriTes'));
    }
}
