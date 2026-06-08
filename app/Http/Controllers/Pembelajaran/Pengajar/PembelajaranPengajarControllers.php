<?php

namespace App\Http\Controllers\Pembelajaran\Pengajar;

use App\Http\Controllers\Controller;
use App\Models\KategoriTes;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\TipeSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PembelajaranPengajarControllers extends Controller
{
    public function index()
    {
        $kategoriTes = KategoriTes::withCount('tesPengetahuan')->get();
        return view('pembelajaran.pengajar.index_pengajar_pembelajaran', compact('kategoriTes'));
    }

    public function create()
    {
        $kategoriTes = KategoriTes::all();
        return view('pembelajaran.pengajar.create_tes', compact('kategoriTes'));
    }

    public function store(Request $request)
    {
        // Validasi
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
                // Buat record soal tanpa gambar terlebih dahulu untuk mendapatkan ID asli
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

                // Update gambar menggunakan ID soal yang baru saja di-generate
                $updates = [];

                // Helper untuk proses simpan file ke public_folder seperti logic Filament
                $saveFile = function ($file, $columnName, $prefixName) use ($soal) {
                    if (!$file) return null;
                    
                    // Format penamaan file sesuai logic Filament Anda
                    $ext = $file->getClientOriginalExtension();
                    $datetime = now()->format('Ymd_His');
                    $fileName = "{$prefixName}_{$datetime}_{$soal->id}.{$ext}";
                    
                    // Path folder target di folder public aplikasi
                    // Sesuai dengan disk public_folder: public/media/soal/{soalId}/{kolom}
                    $destinationPath = public_path("media/soal/{$soal->id}/{$columnName}");
                    
                    // Buat direktori jika belum ada
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }

                    // Pindahkan file ke folder public
                    $file->move($destinationPath, $fileName);

                    // Kembalikan relative path (untuk di-store ke database)
                    return "media/soal/{$soal->id}/{$columnName}/{$fileName}";
                };

                // Proses file Pertanyaan
                if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                    $updates['visual_pertanyaan'] = $saveFile(
                        $request->file("soal.{$index}.visual_pertanyaan"), 
                        'visual_pertanyaan', 
                        'pertanyaan'
                    );
                }

                // Proses file Pilihan Ganda (A-D)
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

                // Jika ada gambar yang di-upload, lakukan satu kali update
                if (!empty($updates)) {
                    $soal->update($updates);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tes berhasil diterbitkan dengan kode: ' . $tes->kode_tes,
                'redirect' => route('pembelajaran.pengajar.index')
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
     * Memproses Update Data
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_tes,id',
            'judul_tes' => 'required|string|max:255',
            'batas_waktu' => 'required|integer|min:1',
            'soal' => 'required|array|min:1',
            // Validasi longgar karena id soal lama bisa ikut terkirim
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

            // Track ID soal yang dikirim dari form (untuk mendeteksi soal yang dihapus)
            $soalIdsDariForm = [];
            $soalArray = $request->all()['soal'] ?? [];

            // Helper File Upload
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
                    // UPDATE SOAL LAMA
                    $soal = Soal::find($soalIdLama);
                    if ($soal) {
                        $soal->update($dataSoal);
                        $soalIdsDariForm[] = $soal->id;
                    }
                } else {
                    // CREATE SOAL BARU
                    $soal = Soal::create($dataSoal);
                    $soalIdsDariForm[] = $soal->id;
                }

                // Proses Update Gambar (Hanya jika ada file baru yang diunggah)
                $updatesGambar = [];
                if ($request->hasFile("soal.{$index}.visual_pertanyaan")) {
                    // Hapus gambar lama jika ada
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

            // 3. Hapus soal (dan foldernya) yang tidak ada di payload form
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
                'redirect' => route('pembelajaran.pengajar.index')
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
     * Memproses Hapus Data (Delete)
     */
    public function destroy($id)
    {
        try {
            $tes = TesPengetahuan::findOrFail($id);
            
            // Hapus direktori fisik gambar milik seluruh soal di dalam tes ini
            $soals = Soal::where('tipe_soal_id', $tes->tipe_soal_id)->get();
            foreach($soals as $soal) {
                $path = public_path("media/soal/{$soal->id}");
                if(File::exists($path)) {
                    File::deleteDirectory($path); // Bersihkan folder public/media/soal/{id}
                }
            }
            
            // Hapus record utama (Relasi cascade di database biasanya menangani record childnya, 
            // tapi kita hapus manual untuk keamanan)
            Soal::where('tipe_soal_id', $tes->tipe_soal_id)->delete();
            TipeSoal::where('id', $tes->tipe_soal_id)->delete();
            $tes->delete();

            return response()->json([
                'success' => true, 
                'message' => 'Tes dan seluruh gambar terkait berhasil dihapus permanen.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menghapus tes: ' . $e->getMessage()
            ], 500);
        }
    }
}