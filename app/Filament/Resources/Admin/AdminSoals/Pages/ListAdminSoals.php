<?php

namespace App\Filament\Resources\Admin\AdminSoals\Pages;

use App\Filament\Resources\Admin\AdminSoals\AdminSoalResource;
use App\Models\TesPengetahuan;
use App\Models\KategoriTes; // Pastikan model ini di-import
use App\Models\TipeSoal;    // Pastikan model ini di-import
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
                        // Menggunakan null safe operator (?->) untuk mencegah error jika ID tidak ditemukan
                        $kategoriTitle = KategoriTes::find($data['kategori_tes_id'])?->title ?? 'Tanpa Kategori';
                        $tipeTitle = TipeSoal::find($data['tipe_soal_id'])?->title ?? 'Tanpa Tipe';
                        
                        // Gabungkan title, misalnya: "Matematika - Pilihan Ganda"
                        $namaPelajaran = $kategoriTitle . ' - ' . $tipeTitle;

                        // 3. Create or Update Tes Pengetahuan
                        // Kita cari apakah Tes Pengetahuan dengan kombinasi kategori & tipe ini sudah ada
                        $tesPengetahuan = TesPengetahuan::firstOrNew([
                            'kategori_tes_id' => $data['kategori_tes_id'],
                            'tipe_soal_id'    => $data['tipe_soal_id'],
                        ]);

                        $tesPengetahuan->pelajaran = $namaPelajaran;
                        $tesPengetahuan->soal_id = $soal->id; 

                        // MENGUBAH LOGIKA TOTAL SOAL: 
                        // Hitung langsung dari database secara real-time, bukan sekadar ditambah 1
                        $tesPengetahuan->total_soal = $model::where('kategori_tes_id', $data['kategori_tes_id'])
                            ->where('tipe_soal_id', $data['tipe_soal_id'])
                            ->count();

                        $tesPengetahuan->save();

                        return $soal;
                    });
                }),
        ];
    }
}