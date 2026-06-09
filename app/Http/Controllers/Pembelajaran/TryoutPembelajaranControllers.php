<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use App\Models\KategoriTes;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\HasilTes; // Jangan lupa import model HasilTes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutPembelajaranControllers extends Controller
{
    public function index()
    {
        // Cek apakah user memiliki kelas (premium/berbayar)
        $user = Auth::user();
        $hasKelas = $user?->profile?->kelas_id !== null;

        // Ambil keseluruhan data tanpa limit untuk halaman "Tryout Ku"
        $kategoriTes = KategoriTes::with(['tesPengetahuan' => function ($query) use ($hasKelas) {
            $query->where('status', 1)->withCount('hasilTes');

            // Jika user tidak punya kelas, hanya tampilkan tes gratis (is_paid = 0)
            if (!$hasKelas) {
                $query->where('is_paid', 0);
            }
        }])->get();

        return view('pembelajaran.tryoutku_pembelajaran', compact('kategoriTes'));
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
        $nilaiDiperoleh = 0; // Akumulasi bobot_nilai dari jawaban benar

        // 4. Kalkulasi Nilai berdasarkan bobot_nilai per soal
        if (is_array($jawabanUser)) {
            foreach ($jawabanUser as $soalId => $data) {
                $soal = $soalList->get($soalId);

                if ($soal) {
                    $jawabanPilihan = $data['answer'];

                    if (empty($jawabanPilihan)) {
                        $jumlahKosong++;
                    } elseif (strtoupper($jawabanPilihan) === strtoupper($soal->jawaban_benar)) {
                        $jumlahBenar++;
                        // Tambahkan bobot soal ini ke nilai yang diperoleh
                        $nilaiDiperoleh += (float) $soal->bobot_nilai;
                    } else {
                        $jumlahSalah++;
                    }
                }
            }
        }

        // 5. Total nilai = akumulasi bobot_nilai dari soal yang dijawab benar.
        //    Skor maksimal tes = total_bobot (akumulasi seluruh bobot_nilai).
        //    Fallback: jika total_bobot belum tersedia, hitung langsung dari soal.
        $totalBobot = (int) $tesPengetahuan->total_bobot > 0
            ? (int) $tesPengetahuan->total_bobot
            : (int) $soalList->sum('bobot_nilai');

        $totalNilai = $nilaiDiperoleh;

        // 6. Simpan Hasil ke Database
        HasilTes::create([
            'user_id' => Auth::id(), // Pastikan user sudah login
            'kategori_tes_id' => $tesPengetahuan->kategori_tes_id,
            'tes_pengetahuan_id' => $tesPengetahuan->id,
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah + $jumlahKosong, // Soal tidak dijawab dihitung salah
            'total_nilai' => number_format($totalNilai, 2, '.', ''), // Menyimpan nilai format desimal seperti "85.50"
            // Estimasi waktu dimulai dikurangi dari durasi, bisa diubah jika frontend mencatat realtime
            'waktu_dimulai' => now()->subMinutes($tesPengetahuan->batas_waktu), 
            'waktu_berakhir' => now(),
            'status' => 1, // Selesai
        ]);

        // 7. Redirect ke halaman riwayat/statistik atau kembali ke index pembelajaran
        return redirect()->route('pembelajaran.index')
            ->with('success', 'Ujian berhasil diselesaikan! Skor Anda: ' . number_format($totalNilai, 2) . ' dari ' . $totalBobot);
    }

    /**
     * Memvalidasi kode tes dari frontend via AJAX
     */
public function validateCode(Request $request)
    {
        // Ubah tes_id menjadi nullable agar mendukung pencarian dari Hero Section
        $request->validate([
            'tes_id' => 'nullable|exists:tes_pengetahuan,id',
            'kode_tes' => 'required|string',
        ]);

        if ($request->filled('tes_id')) {
            // Skenario 1: User mengklik kartu ujian tertentu (Modal)
            $tes = TesPengetahuan::find($request->tes_id);
            if ($tes && $tes->kode_tes === $request->kode_tes) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('pembelajaran.cat.show', $tes->id)
                ]);
            }
        } else {
            // Skenario 2: User memasukkan kode di Hero Section (Pencarian Global)
            $tes = TesPengetahuan::where('kode_tes', $request->kode_tes)
                ->where('status', 1) // Pastikan tes tersebut berstatus aktif
                ->first();
                
            if ($tes) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('pembelajaran.cat.show', $tes->id)
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Kode tes salah atau tidak ditemukan.'
        ], 422);
    }
}