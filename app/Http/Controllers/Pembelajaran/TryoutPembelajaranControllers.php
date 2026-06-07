<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\HasilTes; // Jangan lupa import model HasilTes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutPembelajaranControllers extends Controller
{
    public function index()
    {
        return view('pembelajaran.tryoutku_pembelajaran');
    }

    public function show(string $id)
    {
        // 1. Ambil data tes pengetahuan
        $tesPengetahuan = TesPengetahuan::with(['kategoriTes', 'tipeSoal'])->findOrFail($id);

        // 2. Tarik soal berdasarkan kategori dan tipe
        $soal = Soal::with('kategoriTes')
            ->where('kategori_tes_id', $tesPengetahuan->kategori_tes_id)
            ->where('tipe_soal_id', $tesPengetahuan->tipe_soal_id)
            ->inRandomOrder()
            ->limit($tesPengetahuan->total_soal)
            ->get();

        // 3. Transformasi ke format array
        $exam_data = [
            'id' => $tesPengetahuan->id,
            'title' => $tesPengetahuan->pelajaran ?? 'Tryout CAT',
            'duration_minutes' => (int) $tesPengetahuan->batas_waktu,
            'questions' => $soal->map(function ($q) {
                
                $options = [];
                $letters = ['a', 'b', 'c', 'd', 'e'];
                
                foreach ($letters as $letter) {
                    $textColumn = 'jawaban_' . $letter;
                    $visualColumn = 'visual_jawaban_' . $letter;
                    
                    if (!empty($q->$textColumn) || !empty($q->$visualColumn)) {
                        $options[strtoupper($letter)] = [
                            'text' => $q->$textColumn,
                            'visual' => $q->$visualColumn ? asset($q->$visualColumn) : null,
                        ];
                    }
                }

                return [
                    'id' => $q->id,
                    'kategori' => $q->kategoriTes->title ?? 'Umum',
                    'text' => $q->pertanyaan,
                    'visual' => $q->visual_pertanyaan ? asset($q->visual_pertanyaan) : null,
                    'options' => $options,
                ];
            })->values()->toArray()
        ];

        return view('pembelajaran.cat_pembelajaran', compact('exam_data', 'tesPengetahuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // 1. Ambil data tes yang dikerjakan
        $tesPengetahuan = TesPengetahuan::findOrFail($id);

        // 2. Decode payload jawaban dari frontend
        // Format asal: {"1": {"answer": "A", "is_doubt": false}, "2": {"answer": null, ...}}
        $jawabanUser = json_decode($request->input('jawaban_user'), true);

        // 3. Tarik kembali soal untuk mengecek kunci jawaban
        // Gunakan keyBy('id') agar pencarian soal lebih cepat tanpa harus query berulang kali
        $soalList = Soal::where('kategori_tes_id', $tesPengetahuan->kategori_tes_id)
            ->where('tipe_soal_id', $tesPengetahuan->tipe_soal_id)
            ->get()
            ->keyBy('id');

        $jumlahBenar = 0;
        $jumlahSalah = 0;
        $jumlahKosong = 0;

        // 4. Kalkulasi Nilai
        if (is_array($jawabanUser)) {
            foreach ($jawabanUser as $soalId => $data) {
                $soal = $soalList->get($soalId);

                if ($soal) {
                    $jawabanPilihan = $data['answer'];

                    if (empty($jawabanPilihan)) {
                        $jumlahKosong++;
                    } elseif (strtoupper($jawabanPilihan) === strtoupper($soal->jawaban_benar)) {
                        $jumlahBenar++;
                    } else {
                        $jumlahSalah++;
                    }
                }
            }
        }

        // 5. Hitung Skor (Skala 100)
        // Jika total soal lebih dari yang dijawab, ambil total_soal dari tabel tes_pengetahuan
        $totalSoalUjian = $tesPengetahuan->total_soal > 0 ? $tesPengetahuan->total_soal : count($soalList);
        $totalNilai = $totalSoalUjian > 0 ? ($jumlahBenar / $totalSoalUjian) * 100 : 0;

        // 6. Simpan Hasil ke Database
        HasilTes::create([
            'user_id' => Auth::id(), // Pastikan user sudah login
            'kategori_tes_id' => $tesPengetahuan->kategori_tes_id,
            'tes_pengetahuan_id' => $tesPengetahuan->id,
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah + $jumlahKosong, // Soal tidak dijawab dihitung salah
            'total_nilai' => number_format($totalNilai, 2), // Menyimpan nilai format desimal seperti "85.50"
            // Estimasi waktu dimulai dikurangi dari durasi, bisa diubah jika frontend mencatat realtime
            'waktu_dimulai' => now()->subMinutes($tesPengetahuan->batas_waktu), 
            'waktu_berakhir' => now(),
            'status' => 1, // Selesai
        ]);

        // 7. Redirect ke halaman riwayat/statistik atau kembali ke index pembelajaran
        return redirect()->route('pembelajaran.index')
            ->with('success', 'Ujian berhasil diselesaikan! Skor Anda: ' . number_format($totalNilai, 2));
    }
}