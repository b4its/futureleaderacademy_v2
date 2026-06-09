<?php

namespace App\Filament\Resources\Admin\AdminSoals\Pages;

use App\Filament\Resources\Admin\AdminSoals\AdminSoalResource;
use App\Models\TesPengetahuan;
use App\Models\KategoriTes; 
use App\Models\TipeSoal;    
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 

class ListAdminSoals extends ListRecords
{
    protected static string $resource = AdminSoalResource::class;
    protected static ?string $title = "Daftar Soal";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambahkan Soal')
                ->modalHeading('Tambahkan Soal')
                ->using(function (array $data, string $model): Model {
                    return DB::transaction(function () use ($data, $model) {
                        
                        // 1. Buat record Soal (Model Utama) terlebih dahulu
                        $soal = $model::create($data);

                        // 2. Ambil title dari relasi untuk mengisi kolom 'pelajaran'
                        $kategoriTitle = KategoriTes::find($data['kategori_tes_id'])?->title ?? 'Tanpa Kategori';
                        $tipeTitle = TipeSoal::find($data['tipe_soal_id'])?->title ?? 'Tanpa Tipe';
                        
                        // Gabungkan title, misalnya: "Matematika - Pilihan Ganda"
                        $namaPelajaran = $kategoriTitle . ' - ' . $tipeTitle;

                        // 3. LOGIKA GENERATE KODE TES 7 DIGIT UNIQUE
                        // Kita cek apakah TesPengetahuan untuk kombinasi kategori & tipe ini sudah ada
                        $tesPengetahuan = TesPengetahuan::where('kategori_tes_id', $data['kategori_tes_id'])
                            ->where('tipe_soal_id', $data['tipe_soal_id'])
                            ->first();

                        // Jika BELUM ADA, buat baru dan generate kode_tes unik 7 digit
                        if (!$tesPengetahuan) {
                            $tesPengetahuan = new TesPengetahuan();
                            $tesPengetahuan->kategori_tes_id = $data['kategori_tes_id'];
                            $tesPengetahuan->tipe_soal_id = $data['tipe_soal_id'];

                            // Looping untuk memastikan kode benar-benar unik di database
                            do {
                                // Str::random menghasilkan kombinasi huruf (uppercase/lowercase) dan angka
                                // Jika ingin huruf besar semua, bisa gunakan: strtoupper(Str::random(7))
                                $kodeRandom = strtoupper(Str::random(7)); 
                                $isExists = TesPengetahuan::where('kode_tes', $kodeRandom)->exists();
                            } while ($isExists);

                            $tesPengetahuan->kode_tes = $kodeRandom;
                        }

                        // 4. Update data pelengkap
                        $tesPengetahuan->pelajaran = $namaPelajaran;

                        // 5. Hitung ulang total_soal & total_bobot secara real-time.
                        //    total_bobot = akumulasi seluruh bobot_nilai (skor maksimal tes).
                        $soalQuery = $model::where('kategori_tes_id', $data['kategori_tes_id'])
                            ->where('tipe_soal_id', $data['tipe_soal_id']);

                        $tesPengetahuan->total_soal = $soalQuery->count();
                        $tesPengetahuan->total_bobot = (int) $soalQuery->sum('bobot_nilai');

                        $tesPengetahuan->save();

                        return $soal;
                    });
                }),
        ];
    }
}