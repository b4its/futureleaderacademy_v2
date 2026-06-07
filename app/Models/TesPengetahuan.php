<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    public function hasilTes(): HasMany
    {
        return $this->hasMany(HasilTes::class);
    }
}