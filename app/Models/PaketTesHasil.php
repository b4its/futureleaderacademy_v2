<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketTesHasil extends Model
{
    protected $table = 'paket_tes_hasil';

    protected $fillable = [
        'user_id',
        'paket_tes_id',
        'mode_penilaian',
        'total_nilai',
        'total_bobot',
        'jumlah_benar',
        'jumlah_salah',
        'waktu_dimulai',
        'waktu_berakhir',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'waktu_dimulai' => 'datetime',
            'waktu_berakhir' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paketTes(): BelongsTo
    {
        return $this->belongsTo(PaketTes::class);
    }

    /**
     * Rincian nilai per sub-tes dari sesi pengerjaan paket ini.
     */
    public function detail(): HasMany
    {
        return $this->hasMany(HasilTes::class, 'paket_tes_hasil_id');
    }

    public function tampilkanGabungan(): bool
    {
        return in_array($this->mode_penilaian, [PaketTes::MODE_GABUNGAN, PaketTes::MODE_KEDUANYA], true);
    }

    public function tampilkanTerpisah(): bool
    {
        return in_array($this->mode_penilaian, [PaketTes::MODE_TERPISAH, PaketTes::MODE_KEDUANYA], true);
    }
}
