<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistikPembelajaranControllers extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('auth.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 1. Ambil Riwayat Hasil Tes User
        $riwayatTes = HasilTes::with(['tesPengetahuan.kategoriTes'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Kalkulasi Overview Statistik
        $totalKuisSelesai = $riwayatTes->count();
        
        $rataRataNilai = $totalKuisSelesai > 0 
            ? round($riwayatTes->avg('total_nilai'), 2) 
            : 0;

        $totalBenarSemua = $riwayatTes->sum('jumlah_benar');
        $totalSalahSemua = $riwayatTes->sum('jumlah_salah');
        $totalSoalDikerjakan = $totalBenarSemua + $totalSalahSemua;
        
        $akurasiJawaban = $totalSoalDikerjakan > 0 
            ? round(($totalBenarSemua / $totalSoalDikerjakan) * 100) 
            : 0;

        $totalWaktuMenit = 0;
        foreach ($riwayatTes as $tes) {
            if ($tes->waktu_dimulai && $tes->waktu_berakhir) {
                $totalWaktuMenit += $tes->waktu_berakhir->diffInMinutes($tes->waktu_dimulai);
            }
        }
        $jamBelajar = floor($totalWaktuMenit / 60);
        $menitBelajar = $totalWaktuMenit % 60;

        $grafikNilai = $riwayatTes->take(7)->reverse()->map(function ($tes, $index) {
            // Skor maksimal diambil dari total_bobot tes terkait (fallback 100 bila kosong)
            $nilaiMaksimal = (int) ($tes->tesPengetahuan->total_bobot ?? 0);
            if ($nilaiMaksimal <= 0) {
                $nilaiMaksimal = 100;
            }
            $persentase = $nilaiMaksimal > 0 ? ($tes->total_nilai / $nilaiMaksimal) * 100 : 0;

            return [
                'label' => 'TO ' . ($index + 1),
                'nilai' => $tes->total_nilai,
                'nilai_maksimal' => $nilaiMaksimal,
                'height' => min(max($persentase, 5), 100) . '%'
            ];
        })->values();

        // 3. Mengelompokkan Data Riwayat untuk Tabel & Modal
        // Menggunakan tes_pengetahuan_id agar 1 jenis tes tergabung menjadi 1 baris
        $groupedRiwayat = $riwayatTes->groupBy('tes_pengetahuan_id')->map(function ($attempts) {
            $testInfo = $attempts->first()->tesPengetahuan;
            $highestScore = $attempts->max('total_nilai');
            $latestAttempt = $attempts->first(); 

            // Skor maksimal tes = total_bobot (fallback 100 bila belum diisi)
            $nilaiMaksimal = (int) ($testInfo->total_bobot ?? 0);
            if ($nilaiMaksimal <= 0) {
                $nilaiMaksimal = 100;
            }

            // Ambang lulus = 65% dari nilai maksimal
            $batasLulus = $nilaiMaksimal * 0.65;

            // Urutkan attempt dari awal (terlama) sampai akhir (terbaru) untuk ditampilkan di modal
            $history = $attempts->sortBy('created_at')->values()->map(function ($attempt, $index) use ($batasLulus) {
                $totalSoal = $attempt->jumlah_benar + $attempt->jumlah_salah;
                $akurasi = $totalSoal > 0 ? round(($attempt->jumlah_benar / $totalSoal) * 100) : 0;
                $isLulus = $attempt->total_nilai >= $batasLulus; 

                return [
                    'percobaan_ke' => $index + 1,
                    'tanggal' => $attempt->created_at->format('d M Y, H:i'),
                    'skor' => $attempt->total_nilai,
                    'akurasi' => $akurasi,
                    'is_lulus' => $isLulus
                ];
            });

            return [
                'tes_id' => $testInfo->id ?? 0,
                'kode_tes' => $testInfo->kode_tes ?? '-',
                'nama_tes' => $testInfo->pelajaran ?? 'Ujian CAT',
                'kategori' => $testInfo->kategoriTes->title ?? '-',
                'total_percobaan' => $attempts->count(),
                'skor_tertinggi' => $highestScore,
                'nilai_maksimal' => $nilaiMaksimal,
                'terakhir_dikerjakan' => $latestAttempt->created_at->format('d M Y'),
                'is_lulus_terakhir' => $latestAttempt->total_nilai >= $batasLulus,
                'history' => $history->toArray()
            ];
        })->values();

        return view('pembelajaran.statistik_pembelajaran', compact(
            'riwayatTes',
            'totalKuisSelesai',
            'rataRataNilai',
            'akurasiJawaban',
            'jamBelajar',
            'menitBelajar',
            'grafikNilai',
            'groupedRiwayat'
        ));
    }
}