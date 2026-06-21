<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TesPengetahuan extends Model
{
    protected $table = 'tes_pengetahuan';
    
    protected $fillable = [
        'kategori_tes_id',
        'tipe_soal_id',
        'kode_tes',
        'pelajaran',
        'total_soal',
        'batas_waktu',
        'is_paid',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function kategoriTes(): BelongsTo
    {
        return $this->belongsTo(KategoriTes::class);
    }

    public function tipeSoal(): BelongsTo
    {
        return $this->belongsTo(TipeSoal::class, 'tipe_soal_id');
    }

    /**
     * Relasi ke soal. Sebuah tes diidentifikasi oleh kombinasi
     * kategori_tes_id + tipe_soal_id, jadi soal dengan pasangan yang sama
     * dianggap milik tes ini.
     */
    public function soal(): HasMany
    {
        return $this->hasMany(Soal::class, 'tipe_soal_id', 'tipe_soal_id')
            ->where('kategori_tes_id', $this->kategori_tes_id);
    }

    public function hasilTes(): HasMany
    {
        return $this->hasMany(HasilTes::class);
    }

    /**
     * Paket yang memuat tes ini (relasi many-to-many).
     */
    public function paketTes(): BelongsToMany
    {
        return $this->belongsToMany(PaketTes::class, 'paket_tes_tes', 'tes_pengetahuan_id', 'paket_tes_id')
            ->withPivot('urutan')
            ->withTimestamps();
    }

    /**
     * Hitung ulang total_soal dan total_bobot dari seluruh soal yang
     * cocok dengan kategori_tes_id & tipe_soal_id tes ini, lalu simpan.
     */
    public function rekalkulasiBobot(): void
    {
        $query = Soal::where('kategori_tes_id', $this->kategori_tes_id)
            ->where('tipe_soal_id', $this->tipe_soal_id);

        $this->total_soal = $query->count();
        $this->total_bobot = Soal::hitungTotalBobot($this->kategori_tes_id, $this->tipe_soal_id);
        $this->save();
    }
}