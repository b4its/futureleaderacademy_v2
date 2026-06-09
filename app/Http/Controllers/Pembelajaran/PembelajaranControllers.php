<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\KategoriTes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelajaranControllers extends Controller
{
    public function index()
    {
        // Cek apakah user memiliki kelas (premium/berbayar)
        $user = Auth::user();
        $hasKelas = $user?->profile?->kelas_id !== null;

        // Ambil kategori & batasi relasi tes_pengetahuan maksimal 4 per kategori
        $kategoriTes = KategoriTes::with(['tesPengetahuan' => function ($query) use ($hasKelas) {
            $query->where('status', 1)
                  ->withCount('hasilTes');

            // Jika user tidak punya kelas, hanya tampilkan tes gratis (is_paid = 0)
            if (!$hasKelas) {
                $query->where('status', 1)
                    ->where('is_paid', 0);
            }

            $query->limit(4);
        }])->get();

        return view('pembelajaran.index_pembelajaran', compact('kategoriTes'));
    }
}