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

        // --- Pie Chart: Distribusi Nilai ---
        $hasilAll = HasilTes::whereIn('tes_pengetahuan_id', $tesIds)->pluck('total_nilai');
        $distribusiData = [0, 0, 0, 0]; // Sangat Baik, Baik, Cukup, Kurang
        foreach ($hasilAll as $nilai) {
            $n = floatval($nilai);
            if ($n >= 85) $distribusiData[0]++;
            elseif ($n >= 70) $distribusiData[1]++;
            elseif ($n >= 50) $distribusiData[2]++;
            else $distribusiData[3]++;
        }
        $distribusiLabels = ['Sangat Baik (≥85)', 'Baik (70-84)', 'Cukup (50-69)', 'Kurang (<50)'];

        // --- Bar Chart: Rata-rata Nilai Per Tes ---
        $nilaiPerTes = HasilTes::whereIn('hasil_tes.tes_pengetahuan_id', $tesIds)
            ->join('tes_pengetahuan', 'hasil_tes.tes_pengetahuan_id', '=', 'tes_pengetahuan.id')
            ->selectRaw('tes_pengetahuan.pelajaran, AVG(CAST(hasil_tes.total_nilai AS DECIMAL(10,2))) as rata_rata')
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
            return [
                'tes_nama' => $h->tesPengetahuan->pelajaran ?? '-',
                'jumlah_benar' => $h->jumlah_benar,
                'jumlah_salah' => $h->jumlah_salah,
                'total_nilai' => $h->total_nilai,
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
     * Store - Simpan tes baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_tes,id',
            'judul_tes' => 'required|string|max:255',
            'batas_waktu' => 'required|integer|min:1',
            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => 'nullable|string',
            'soal.*.visual_pertanyaan' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'soal.*.opsi' => 'nullable|array',
            'soal.*.opsi.*.teks' => 'nullable|string',
            'soal.*.opsi.*.visual' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'soal.*.jawaban_benar' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $pengajarId = auth()->id();

            // 1. Buat Grup Soal
            $tipeSoal = TipeSoal::create([
                'pengajar_id' => $pengajarId,
                'title' => $validated['judul_tes'],
            ]);

            // 2. Buat Header Tes Pengetahuan
            $tes = TesPengetahuan::create([
                'kategori_tes_id' => $validated['kategori_id'],
                'tipe_soal_id' => $tipeSoal->id,
                'kode_tes' => strtoupper(Str::random(6)),
                'pelajaran' => $validated['judul_tes'],
                'total_soal' => count($validated['soal']),
                'batas_waktu' => $validated['batas_waktu'],
                'is_paid' => 1,
                'status' => 1,
            ]);

            // 3. Simpan Detail Soal dan Gambar
            $soalArray = $request->all()['soal'] ?? [];

            foreach ($soalArray as $index => $itemSoal) {
                $soal = Soal::create([
                    'user_id' => $pengajarId,
                    'pengajar_id' => $pengajarId,
                    'tipe_soal_id' => $tipeSoal->id,
                    'kategori_tes_id' => $validated['kategori_id'],
                    'pertanyaan' => $itemSoal['pertanyaan'] ?? null,
                    'jawaban_a' => $itemSoal['opsi']['A']['teks'] ?? null,
                    'jawaban_b' => $itemSoal['opsi']['B']['teks'] ?? null,
                    'jawaban_c' => $itemSoal['opsi']['C']['teks'] ?? null,
                    'jawaban_d' => $itemSoal['opsi']['D']['teks'] ?? null,
                    'jawaban_benar' => strtoupper($itemSoal['jawaban_benar']),
                ]);

                $updates = [];

                $saveFile = function ($file, $columnName, $prefixName) use ($soal) {
                    if (!$file) return null;
                    $ext = $file->getClientOriginalExtension();
                    $datetime = now()->format('Ymd_His');
                    $fileName = "{$prefixName}_{$datetime}_{$soal->id}.{$ext}";
                    $destinationPath = public_path("media/soal/{$soal->id}/{$columnName}");
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $fileName);
                    return "media/soal/{$soal->id}/{$columnName}/{$fileName}";
                };

                if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                    $updates['visual_pertanyaan'] = $saveFile(
                        $request->file("soal.{$index}.visual_pertanyaan"),
                        'visual_pertanyaan',
                        'pertanyaan'
                    );
                }

                foreach (['A', 'B', 'C', 'D'] as $abjad) {
                    $lowerAbjad = strtolower($abjad);
                    if ($request->hasFile("soal.{$index}.opsi.{$abjad}.visual")) {
                        $updates["visual_jawaban_{$lowerAbjad}"] = $saveFile(
                            $request->file("soal.{$index}.opsi.{$abjad}.visual"),
                            "visual_jawaban_{$lowerAbjad}",
                            "jawab_{$lowerAbjad}"
                        );
                    }
                }

                if (!empty($updates)) {
                    $soal->update($updates);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tes berhasil diterbitkan dengan kode: ' . $tes->kode_tes,
                'redirect' => route('pembelajaran.pengajar.kelola')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
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
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_tes,id',
            'judul_tes' => 'required|string|max:255',
            'batas_waktu' => 'required|integer|min:1',
            'soal' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $pengajarId = auth()->id();
            $tes = TesPengetahuan::findOrFail($id);
            $tipeSoalId = $tes->tipe_soal_id;

            // 1. Update Header
            TipeSoal::where('id', $tipeSoalId)->update(['title' => $validated['judul_tes']]);
            $tes->update([
                'kategori_tes_id' => $validated['kategori_id'],
                'pelajaran' => $validated['judul_tes'],
                'total_soal' => count($validated['soal']),
                'batas_waktu' => $validated['batas_waktu'],
            ]);

            $soalIdsDariForm = [];
            $soalArray = $request->all()['soal'] ?? [];

            $saveFile = function ($file, $soalId, $columnName, $prefixName) {
                if (!$file) return null;
                $ext = $file->getClientOriginalExtension();
                $fileName = "{$prefixName}_" . now()->format('Ymd_His') . "_{$soalId}.{$ext}";
                $destinationPath = public_path("media/soal/{$soalId}/{$columnName}");
                if (!File::exists($destinationPath)) File::makeDirectory($destinationPath, 0755, true);
                $file->move($destinationPath, $fileName);
                return "media/soal/{$soalId}/{$columnName}/{$fileName}";
            };

            foreach ($soalArray as $index => $itemSoal) {
                $soalIdLama = $itemSoal['id'] ?? null;

                $dataSoal = [
                    'user_id' => $pengajarId,
                    'pengajar_id' => $pengajarId,
                    'tipe_soal_id' => $tipeSoalId,
                    'kategori_tes_id' => $validated['kategori_id'],
                    'pertanyaan' => $itemSoal['pertanyaan'] ?? null,
                    'jawaban_a' => $itemSoal['opsi']['A']['teks'] ?? null,
                    'jawaban_b' => $itemSoal['opsi']['B']['teks'] ?? null,
                    'jawaban_c' => $itemSoal['opsi']['C']['teks'] ?? null,
                    'jawaban_d' => $itemSoal['opsi']['D']['teks'] ?? null,
                    'jawaban_benar' => strtoupper($itemSoal['jawaban_benar']),
                ];

                if ($soalIdLama) {
                    $soal = Soal::find($soalIdLama);
                    if ($soal) {
                        $soal->update($dataSoal);
                        $soalIdsDariForm[] = $soal->id;
                    }
                } else {
                    $soal = Soal::create($dataSoal);
                    $soalIdsDariForm[] = $soal->id;
                }

                $updatesGambar = [];
                if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                    if ($soal->visual_pertanyaan && File::exists(public_path($soal->visual_pertanyaan))) {
                        File::delete(public_path($soal->visual_pertanyaan));
                    }
                    $updatesGambar['visual_pertanyaan'] = $saveFile($request->file("soal.{$index}.visual_pertanyaan"), $soal->id, 'visual_pertanyaan', 'pertanyaan');
                }

                foreach (['A', 'B', 'C', 'D'] as $abjad) {
                    $low = strtolower($abjad);
                    if ($request->hasFile("soal.{$index}.opsi.{$abjad}.visual")) {
                        $kolomGambar = "visual_jawaban_{$low}";
                        if ($soal->$kolomGambar && File::exists(public_path($soal->$kolomGambar))) {
                            File::delete(public_path($soal->$kolomGambar));
                        }
                        $updatesGambar[$kolomGambar] = $saveFile($request->file("soal.{$index}.opsi.{$abjad}.visual"), $soal->id, $kolomGambar, "jawab_{$low}");
                    }
                }

                if (!empty($updatesGambar)) {
                    $soal->update($updatesGambar);
                }
            }

            // Hapus soal yang tidak ada di payload
            $soalDihapus = Soal::where('tipe_soal_id', $tipeSoalId)->whereNotIn('id', $soalIdsDariForm)->get();
            foreach ($soalDihapus as $sDel) {
                $path = public_path("media/soal/{$sDel->id}");
                if (File::exists($path)) File::deleteDirectory($path);
                $sDel->delete();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tes berhasil diperbarui!',
                'redirect' => route('pembelajaran.pengajar.kelola')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
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