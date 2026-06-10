<?php

namespace App\Http\Controllers\Pembelajaran\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use App\Models\KategoriTes;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\TipeSoal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PembelajaranPengajarControllers extends Controller
{
    /**
     * Dashboard Pengajar - Index dengan grafik dan statistik
     */
    public function index()
    {
        $pengajarId = auth()->id();

        // Ambil tipe_soal milik pengajar ini
        $tipeSoalIds = TipeSoal::where('pengajar_id', $pengajarId)->pluck('id');

        // Ambil tes_pengetahuan yang terkait
        $tesIds = TesPengetahuan::whereIn('tipe_soal_id', $tipeSoalIds)->pluck('id');

        // --- Stat Cards ---
        $totalTes = $tesIds->count();
        $totalSoal = Soal::where('pengajar_id', $pengajarId)->count();
        $totalPengerjaan = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)->count();
        $totalPeserta = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)
            ->distinct('user_id')->count('user_id');

        // --- Line Chart: Tren Pengerjaan 30 Hari ---
        $trenRaw = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $trenLabels = [];
        $trenData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $trenLabels[] = Carbon::parse($date)->format('d M');
            $trenData[] = $trenRaw->get($date)->jumlah ?? 0;
        }

        // --- Pie Chart: Distribusi Nilai (berbasis persentase terhadap total_bobot) ---
        $hasilAll = HasilTes::whereIn('hasil_tes.tes_pengetahuan_id', $tesIds)
            ->join('tes_pengetahuan', 'hasil_tes.tes_pengetahuan_id', '=', 'tes_pengetahuan.id')
            ->selectRaw('hasil_tes.total_nilai, tes_pengetahuan.total_bobot')
            ->get();
        $distribusiData = [0, 0, 0, 0]; // Sangat Baik, Baik, Cukup, Kurang
        foreach ($hasilAll as $hasil) {
            $maks = (int) $hasil->total_bobot > 0 ? (int) $hasil->total_bobot : 100;
            $persentase = ($maks > 0) ? (floatval($hasil->total_nilai) / $maks) * 100 : 0;
            if ($persentase >= 85) $distribusiData[0]++;
            elseif ($persentase >= 70) $distribusiData[1]++;
            elseif ($persentase >= 50) $distribusiData[2]++;
            else $distribusiData[3]++;
        }
        $distribusiLabels = ['Sangat Baik (≥85%)', 'Baik (70-84%)', 'Cukup (50-69%)', 'Kurang (<50%)'];

        // --- Bar Chart: Rata-rata Nilai Per Tes (dalam persentase terhadap total_bobot) ---
        $nilaiPerTes = HasilTes::whereIn('hasil_tes.tes_pengetahuan_id', $tesIds)
            ->join('tes_pengetahuan', 'hasil_tes.tes_pengetahuan_id', '=', 'tes_pengetahuan.id')
            ->selectRaw('tes_pengetahuan.pelajaran, AVG(CAST(hasil_tes.total_nilai AS DECIMAL(10,2)) / NULLIF(tes_pengetahuan.total_bobot, 0) * 100) as rata_rata')
            ->groupBy('tes_pengetahuan.id', 'tes_pengetahuan.pelajaran')
            ->orderByDesc('rata_rata')
            ->limit(10)
            ->get();

        $nilaiPerTesLabels = $nilaiPerTes->pluck('pelajaran')->toArray();
        $nilaiPerTesData = $nilaiPerTes->pluck('rata_rata')->map(fn($v) => round(floatval($v), 1))->toArray();

        // --- Bar Chart: Pengerjaan Per Kategori ---
        $perKategori = HasilTes::whereIn('hasil_tes.tes_pengetahuan_id', $tesIds)
            ->join('kategori_tes', 'hasil_tes.kategori_tes_id', '=', 'kategori_tes.id')
            ->selectRaw('kategori_tes.title, COUNT(*) as jumlah')
            ->groupBy('kategori_tes.id', 'kategori_tes.title')
            ->get();

        $perKategoriLabels = $perKategori->pluck('title')->toArray();
        $perKategoriData = $perKategori->pluck('jumlah')->toArray();

        // --- Recent Activity ---
        $recentActivity = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)
            ->with(['user', 'tesPengetahuan'])
            ->latest()
            ->take(8)
            ->get();

        return view('pembelajaran.pengajar.index_pengajar_pembelajaran', compact(
            'totalTes', 'totalSoal', 'totalPeserta', 'totalPengerjaan',
            'trenLabels', 'trenData',
            'distribusiLabels', 'distribusiData',
            'nilaiPerTesLabels', 'nilaiPerTesData',
            'perKategoriLabels', 'perKategoriData',
            'recentActivity'
        ));
    }

    /**
     * Kelola Tes - Halaman CRUD list semua tes
     */
    public function kelola()
    {
        $pengajarId = auth()->id();

        $tipeSoalIds = TipeSoal::where('pengajar_id', $pengajarId)->pluck('id');

        $kategoriTes = KategoriTes::with(['tesPengetahuan' => function ($query) use ($tipeSoalIds) {
            $query->whereIn('tipe_soal_id', $tipeSoalIds);
        }])->get();

        $tipeSoal = TipeSoal::where('pengajar_id', $pengajarId)->get();

        return view('pembelajaran.pengajar.kelola_tes', compact('kategoriTes', 'tipeSoal'));
    }

    /**
     * Progress Member - Halaman monitoring peserta
     */
    public function progress()
    {
        $pengajarId = auth()->id();

        $tipeSoalIds = TipeSoal::where('pengajar_id', $pengajarId)->pluck('id');
        $tesIds = TesPengetahuan::whereIn('tipe_soal_id', $tipeSoalIds)->pluck('id');

        $tesList = TesPengetahuan::whereIn('id', $tesIds)->get();

        $hasilTesList = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)
            ->with(['user', 'tesPengetahuan'])
            ->latest()
            ->paginate(20);

        return view('pembelajaran.pengajar.progress_member', compact('hasilTesList', 'tesList'));
    }

    /**
     * Detail Progress per User (AJAX)
     */
    public function progressDetail($userId)
    {
        $pengajarId = auth()->id();

        $tipeSoalIds = TipeSoal::where('pengajar_id', $pengajarId)->pluck('id');
        $tesIds = TesPengetahuan::whereIn('tipe_soal_id', $tipeSoalIds)->pluck('id');

        $hasilUser = HasilTes::where('user_id', $userId)
            ->whereIn('tes_pengetahuan_id', $tesIds)
            ->with('tesPengetahuan')
            ->latest()
            ->get();

        $totalTes = $hasilUser->count();
        $rataRata = $totalTes > 0 ? number_format($hasilUser->avg('total_nilai'), 1) : '0';
        $nilaiTertinggi = $totalTes > 0 ? number_format($hasilUser->max('total_nilai'), 1) : '0';

        $riwayat = $hasilUser->map(function ($h) {
            $nilaiMaksimal = (int) ($h->tesPengetahuan->total_bobot ?? 0);
            if ($nilaiMaksimal <= 0) { $nilaiMaksimal = 100; }

            return [
                'tes_nama' => $h->tesPengetahuan->pelajaran ?? '-',
                'jumlah_benar' => $h->jumlah_benar,
                'jumlah_salah' => $h->jumlah_salah,
                'total_nilai' => $h->total_nilai,
                'nilai_maksimal' => $nilaiMaksimal,
                'tanggal' => $h->created_at->format('d M Y, H:i'),
            ];
        });

        return response()->json([
            'total_tes' => $totalTes,
            'rata_rata' => $rataRata,
            'nilai_tertinggi' => $nilaiTertinggi,
            'riwayat' => $riwayat,
        ]);
    }

    /**
     * Create Tes - Form pembuatan tes baru
     */
    public function create()
    {
        $kategoriTes = KategoriTes::all();
        return view('pembelajaran.pengajar.create_tes', compact('kategoriTes'));
    }

    /**
     * Helper: simpan file gambar soal ke disk public_folder.
     * Mengikuti konvensi media/soal/{id}/{kolom}/{prefix}_{datetime}_{id}.ext
     */
    private function saveSoalImage($file, Soal $soal, string $columnName, string $prefixName): string
    {
        $ext      = $file->getClientOriginalExtension();
        $datetime = now()->format('Ymd_His');
        $fileName = "{$prefixName}_{$datetime}_{$soal->id}.{$ext}";
        $dir      = "media/soal/{$soal->id}/{$columnName}";

        // Pindahkan native ke public_path() agar langsung masuk folder public
        $file->move(public_path($dir), $fileName);

        return "{$dir}/{$fileName}";
    }

    /**
     * Helper: hapus file gambar soal dari folder public.
     */
    private function deleteSoalImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    /**
     * Store - Simpan tes baru.
     * Input soal menggunakan struktur:
     *   soal[{i}][pertanyaan]
     *   soal[{i}][visual_pertanyaan]       (file, opsional)
     *   soal[{i}][mode_pertanyaan]          text | gambar | keduanya
     *   soal[{i}][jawaban_a..e]
     *   soal[{i}][visual_jawaban_a..e]     (file, opsional)
     *   soal[{i}][mode_jawaban_a..e]        text | gambar | keduanya
     *   soal[{i}][jawaban_benar]
     *   soal[{i}][bobot_nilai]              1–5
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:kategori_tes,id',
            'judul_tes'    => 'required|string|max:255',
            'batas_waktu'  => 'required|integer|min:1',
            'soal'         => 'required|array|min:1',
            'soal.*.jawaban_benar' => 'required|string|max:2',
            'soal.*.bobot_nilai'   => 'nullable|integer|min:1|max:5',
        ], [
            'kategori_id.required' => 'Kategori tes wajib dipilih.',
            'judul_tes.required'   => 'Judul tes wajib diisi.',
            'batas_waktu.required' => 'Batas waktu wajib diisi.',
            'soal.required'        => 'Minimal harus ada satu soal.',
        ]);

        DB::beginTransaction();
        try {
            $pengajarId = auth()->id();
            $kategoriId = (int) $request->input('kategori_id');

            // 1. Grup soal (tipe_soal)
            $tipeSoal = TipeSoal::create([
                'pengajar_id' => $pengajarId,
                'title'       => $request->input('judul_tes'),
            ]);

            // 2. Header tes
            $tes = TesPengetahuan::create([
                'kategori_tes_id' => $kategoriId,
                'tipe_soal_id'    => $tipeSoal->id,
                'kode_tes'        => strtoupper(Str::random(6)),
                'pelajaran'       => $request->input('judul_tes'),
                'total_soal'      => count($request->input('soal', [])),
                'batas_waktu'     => $request->input('batas_waktu'),
                'is_paid'         => 1,
                'status'          => 1,
            ]);

            // 3. Soal – ambil langsung dari request (tidak lewat validated)
            //    agar jawaban_a..e, id, dan mode_* tidak terbuang.
            foreach ($request->input('soal', []) as $index => $item) {
                $modePertanyaan = $item['mode_pertanyaan'] ?? 'text';

                $soal = Soal::create([
                    'user_id'         => $pengajarId,
                    'pengajar_id'     => $pengajarId,
                    'tipe_soal_id'    => $tipeSoal->id,
                    'kategori_tes_id' => $kategoriId,
                    'pertanyaan'      => in_array($modePertanyaan, ['text', 'keduanya']) ? ($item['pertanyaan'] ?? null) : null,
                    'jawaban_a'       => $this->resolveJawabanTeks($item, 'a'),
                    'jawaban_b'       => $this->resolveJawabanTeks($item, 'b'),
                    'jawaban_c'       => $this->resolveJawabanTeks($item, 'c'),
                    'jawaban_d'       => $this->resolveJawabanTeks($item, 'd'),
                    'jawaban_e'       => $this->resolveJawabanTeks($item, 'e'),
                    'jawaban_benar'   => strtoupper($item['jawaban_benar'] ?? 'A'),
                    'bobot_nilai'     => max(1, min(5, (int) ($item['bobot_nilai'] ?? 1))),
                ]);

                $updates = [];

                // Gambar pertanyaan
                if (in_array($modePertanyaan, ['gambar', 'keduanya'])) {
                    if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                        $updates['visual_pertanyaan'] = $this->saveSoalImage(
                            $request->file("soal.{$index}.visual_pertanyaan"),
                            $soal, 'visual_pertanyaan', 'pertanyaan'
                        );
                    }
                }

                // Gambar jawaban A–E
                foreach (['a', 'b', 'c', 'd', 'e'] as $ab) {
                    $modeJawaban = $item["mode_jawaban_{$ab}"] ?? 'text';
                    if (in_array($modeJawaban, ['gambar', 'keduanya'])) {
                        $fileKey = "soal.{$index}.visual_jawaban_{$ab}";
                        if ($request->hasFile($fileKey)) {
                            $updates["visual_jawaban_{$ab}"] = $this->saveSoalImage(
                                $request->file($fileKey),
                                $soal, "visual_jawaban_{$ab}", "jawab_{$ab}"
                            );
                        }
                    }
                }

                if (!empty($updates)) {
                    $soal->update($updates);
                }
            }

            DB::commit();
            return response()->json([
                'success'  => true,
                'message'  => 'Tes berhasil diterbitkan dengan kode: ' . $tes->kode_tes,
                'redirect' => route('pembelajaran.pengajar.kelola'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil teks jawaban berdasarkan mode.
     * Jika mode = 'gambar', teks dikosongkan (null).
     */
    private function resolveJawabanTeks(array $item, string $ab): ?string
    {
        $mode = $item["mode_jawaban_{$ab}"] ?? 'text';
        if (in_array($mode, ['text', 'keduanya'])) {
            return $item["jawaban_{$ab}"] ?? null;
        }
        return null;
    }

    /**
     * Edit Form
     */
    public function edit($id)
    {
        $tes = TesPengetahuan::with(['tipeSoal'])->findOrFail($id);
        $kategoriTes = KategoriTes::all();
        $soalList = Soal::where('tipe_soal_id', $tes->tipe_soal_id)->get();

        return view('pembelajaran.pengajar.create_tes', compact('kategoriTes', 'tes', 'soalList'));
    }

    /**
     * Update Header Tes (Opsi: "Edit Tes")
     *
     * Hanya memperbarui data pada tabel tes_pengetahuan (+ judul pada tipe_soal).
     * Tidak menyentuh data soal. Jika kategori berubah, seluruh soal yang
     * terhubung lewat tipe_soal_id ikut dipindahkan agar relasi tetap konsisten.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_tes_id' => 'required|exists:kategori_tes,id',
            'pelajaran'       => 'required|string|max:255',
            'batas_waktu'     => 'required|integer|min:1',
            'is_paid'         => 'required|in:0,1',
            'status'          => 'required|in:0,1',
        ], [
            'kategori_tes_id.required' => 'Kategori tes wajib dipilih.',
            'pelajaran.required'       => 'Judul / nama tes wajib diisi.',
            'batas_waktu.required'     => 'Batas waktu wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $tes = TesPengetahuan::findOrFail($id);
            $tipeSoalId = $tes->tipe_soal_id;
            $kategoriLama = $tes->kategori_tes_id;
            $kategoriBaru = (int) $validated['kategori_tes_id'];

            // Judul tes disimpan juga sebagai title pada grup tipe_soal.
            if ($tipeSoalId) {
                TipeSoal::where('id', $tipeSoalId)->update(['title' => $validated['pelajaran']]);
            }

            $tes->update([
                'kategori_tes_id' => $kategoriBaru,
                'pelajaran'       => $validated['pelajaran'],
                'batas_waktu'     => $validated['batas_waktu'],
                'is_paid'         => (int) $validated['is_paid'],
                'status'          => (int) $validated['status'],
            ]);

            // Jika kategori berubah, pindahkan semua soal terkait agar relasi
            // (tipe_soal_id + kategori_tes_id) tetap menemukan soal yang benar.
            if ($tipeSoalId && $kategoriLama != $kategoriBaru) {
                Soal::where('tipe_soal_id', $tipeSoalId)
                    ->where('kategori_tes_id', $kategoriLama)
                    ->update(['kategori_tes_id' => $kategoriBaru]);
            }

            // Sinkron ulang total_soal & total_bobot.
            $tes->rekalkulasiBobot();

            DB::commit();
            return response()->json([
                'success'  => true,
                'message'  => 'Data tes berhasil diperbarui!',
                'redirect' => route('pembelajaran.pengajar.kelola'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil daftar soal milik sebuah tes (JSON) untuk modal "Edit Soal".
     * Kembalikan visual_* agar front-end dapat menampilkan pratinjau.
     */
    public function getSoal($id)
    {
        $tes = TesPengetahuan::findOrFail($id);

        $soal = Soal::where('tipe_soal_id', $tes->tipe_soal_id)
            ->where('kategori_tes_id', $tes->kategori_tes_id)
            ->orderBy('id')
            ->get([
                'id', 'pertanyaan', 'visual_pertanyaan',
                'jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'jawaban_e',
                'visual_jawaban_a', 'visual_jawaban_b', 'visual_jawaban_c',
                'visual_jawaban_d', 'visual_jawaban_e',
                'jawaban_benar', 'bobot_nilai',
            ]);

        // Tambahkan URL lengkap untuk gambar yang ada
        $soal = $soal->map(function ($s) {
            $base = rtrim(config('app.url'), '/') . '/';
            foreach (['visual_pertanyaan', 'visual_jawaban_a', 'visual_jawaban_b', 'visual_jawaban_c', 'visual_jawaban_d', 'visual_jawaban_e'] as $col) {
                if ($s->$col) {
                    $s->setAttribute($col . '_url', $base . $s->$col);
                } else {
                    $s->setAttribute($col . '_url', null);
                }
            }
            return $s;
        });

        return response()->json([
            'success' => true,
            'tes'     => [
                'id'        => $tes->id,
                'pelajaran' => $tes->pelajaran,
                'kode_tes'  => $tes->kode_tes,
            ],
            'soal'    => $soal,
        ]);
    }

    /**
     * Update Soal (Edit Soal).
     *
     * Bug sebelumnya: iterasi lewat $validated['soal'] yang hanya berisi field
     * yang ada di rules → jawaban_a..e & id terbuang, soal selalu dibuat baru.
     *
     * Fix: ambil data soal langsung dari $request->input('soal') agar semua
     * field (termasuk jawaban_a..e dan id) tersimpan.
     * Gambar disimpan ke disk public_folder mengikuti konvensi Filament.
     */
    public function updateSoal(Request $request, $id)
    {
        $request->validate([
            'soal'                 => 'required|array|min:1',
            'soal.*.jawaban_benar' => 'required|string|max:2',
            'soal.*.bobot_nilai'   => 'nullable|integer|min:1|max:5',
        ], [
            'soal.required'              => 'Minimal harus ada satu soal.',
            'soal.*.jawaban_benar.required' => 'Kunci jawaban pada setiap soal wajib dipilih.',
        ]);

        DB::beginTransaction();
        try {
            $pengajarId = auth()->id();
            $tes        = TesPengetahuan::findOrFail($id);
            $tipeSoalId = $tes->tipe_soal_id;
            $kategoriId = $tes->kategori_tes_id;

            $soalIdsDariForm = [];

            // *** Ambil dari $request->input() agar jawaban_a..e tidak terbuang ***
            foreach ($request->input('soal', []) as $index => $item) {
                $soalIdLama     = $item['id'] ?? null;
                $modePertanyaan = $item['mode_pertanyaan'] ?? 'text';

                $dataSoal = [
                    'user_id'         => $pengajarId,
                    'pengajar_id'     => $pengajarId,
                    'tipe_soal_id'    => $tipeSoalId,
                    'kategori_tes_id' => $kategoriId,
                    'pertanyaan'      => in_array($modePertanyaan, ['text', 'keduanya']) ? ($item['pertanyaan'] ?? null) : null,
                    'jawaban_a'       => $this->resolveJawabanTeks($item, 'a'),
                    'jawaban_b'       => $this->resolveJawabanTeks($item, 'b'),
                    'jawaban_c'       => $this->resolveJawabanTeks($item, 'c'),
                    'jawaban_d'       => $this->resolveJawabanTeks($item, 'd'),
                    'jawaban_e'       => $this->resolveJawabanTeks($item, 'e'),
                    'jawaban_benar'   => strtoupper($item['jawaban_benar'] ?? 'A'),
                    'bobot_nilai'     => max(1, min(5, (int) ($item['bobot_nilai'] ?? 1))),
                ];

                if ($soalIdLama) {
                    $soal = Soal::find($soalIdLama);
                    if ($soal) {
                        // Hapus gambar visual_pertanyaan jika mode berubah ke 'text'
                        if ($modePertanyaan === 'text' && $soal->visual_pertanyaan) {
                            $this->deleteSoalImage($soal->visual_pertanyaan);
                            $dataSoal['visual_pertanyaan'] = null;
                        }
                        // Hapus gambar jawaban jika mode berubah ke 'text'
                        foreach (['a', 'b', 'c', 'd', 'e'] as $ab) {
                            $modeJ = $item["mode_jawaban_{$ab}"] ?? 'text';
                            if ($modeJ === 'text') {
                                $col = "visual_jawaban_{$ab}";
                                if ($soal->$col) {
                                    $this->deleteSoalImage($soal->$col);
                                    $dataSoal[$col] = null;
                                }
                            }
                        }
                        $soal->update($dataSoal);
                        $soalIdsDariForm[] = $soal->id;
                    }
                } else {
                    $soal = Soal::create($dataSoal);
                    $soalIdsDariForm[] = $soal->id;
                }

                // Proses upload gambar
                $updates = [];

                // Gambar pertanyaan
                if (in_array($modePertanyaan, ['gambar', 'keduanya'])) {
                    if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                        // Hapus lama jika ada
                        if ($soal->visual_pertanyaan) {
                            $this->deleteSoalImage($soal->visual_pertanyaan);
                        }
                        $updates['visual_pertanyaan'] = $this->saveSoalImage(
                            $request->file("soal.{$index}.visual_pertanyaan"),
                            $soal, 'visual_pertanyaan', 'pertanyaan'
                        );
                    }
                }

                // Gambar jawaban A–E
                foreach (['a', 'b', 'c', 'd', 'e'] as $ab) {
                    $modeJ = $item["mode_jawaban_{$ab}"] ?? 'text';
                    if (in_array($modeJ, ['gambar', 'keduanya'])) {
                        $fileKey = "soal.{$index}.visual_jawaban_{$ab}";
                        if ($request->hasFile($fileKey)) {
                            $col = "visual_jawaban_{$ab}";
                            if ($soal->$col) {
                                $this->deleteSoalImage($soal->$col);
                            }
                            $updates[$col] = $this->saveSoalImage(
                                $request->file($fileKey),
                                $soal, $col, "jawab_{$ab}"
                            );
                        }
                    }
                }

                if (!empty($updates)) {
                    $soal->update($updates);
                }
            }

            // Hapus soal yang tidak lagi ada di payload (beserta media-nya).
            $soalDihapus = Soal::where('tipe_soal_id', $tipeSoalId)
                ->where('kategori_tes_id', $kategoriId)
                ->whereNotIn('id', $soalIdsDariForm)
                ->get();
            foreach ($soalDihapus as $sDel) {
                // Hapus semua gambar terkait
                foreach (['visual_pertanyaan', 'visual_jawaban_a', 'visual_jawaban_b', 'visual_jawaban_c', 'visual_jawaban_d', 'visual_jawaban_e'] as $col) {
                    $this->deleteSoalImage($sDel->$col);
                }
                $sDel->delete();
            }

            $tes->rekalkulasiBobot();

            DB::commit();
            return response()->json([
                'success'  => true,
                'message'  => 'Soal berhasil diperbarui!',
                'redirect' => route('pembelajaran.pengajar.kelola'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus Tes
     */
    public function destroy($id)
    {
        try {
            $tes = TesPengetahuan::findOrFail($id);

            $soals = Soal::where('tipe_soal_id', $tes->tipe_soal_id)->get();
            foreach ($soals as $soal) {
                $path = public_path("media/soal/{$soal->id}");
                if (File::exists($path)) {
                    File::deleteDirectory($path);
                }
            }

            Soal::where('tipe_soal_id', $tes->tipe_soal_id)->delete();
            TipeSoal::where('id', $tes->tipe_soal_id)->delete();
            $tes->delete();

            return redirect()->route('pembelajaran.pengajar.kelola')
                ->with('success', 'Tes dan seluruh data terkait berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
        }
    }
}