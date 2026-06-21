<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketTes extends Model
{
    protected $table = 'paket_tes';

    /** Mode penilaian paket. */
    public const MODE_TERPISAH = 'terpisah';
    public const MODE_GABUNGAN = 'gabungan';
    public const MODE_KEDUANYA = 'keduanya';

    /**
     * Opsi mode penilaian untuk dropdown form.
     */
    public static function modeOptions(): array
    {
        return [
            self::MODE_TERPISAH => 'Nilai Terpisah (per sub-tes)',
            self::MODE_GABUNGAN => 'Nilai Gabungan (akumulasi)',
            self::MODE_KEDUANYA => 'Terpisah & Gabungan',
        ];
    }

    /**
     * Label ringkas suatu mode (untuk tampilan tabel/badge).
     */
    public static function modeLabel(?string $mode): string
    {
        return match ($mode) {
            self::MODE_GABUNGAN => 'Nilai Gabungan',
            self::MODE_KEDUANYA => 'Terpisah & Gabungan',
            default => 'Nilai Terpisah',
        };
    }

    protected $fillable = [
        'pengajar_id',
        'nama',
        'kode_paket',
        'deskripsi',
        'mode_penilaian',
        'batas_waktu',
        'is_paid',
        'status',
        'total_soal',
        'total_bobot',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'is_paid' => 'boolean',
        ];
    }

    public function pengajar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }

    /**
     * Sub-tes yang tergabung dalam paket ini, terurut sesuai kolom pivot 'urutan'.
     */
    public function tesList(): BelongsToMany
    {
        return $this->belongsToMany(TesPengetahuan::class, 'paket_tes_tes', 'paket_tes_id', 'tes_pengetahuan_id')
            ->withPivot('urutan')
            ->withTimestamps()
            ->orderBy('paket_tes_tes.urutan');
    }

    public function hasil(): HasMany
    {
        return $this->hasMany(PaketTesHasil::class);
    }

    /**
     * Hitung ulang total_soal & total_bobot dari seluruh sub-tes lalu simpan.
     */
    public function rekalkulasi(): void
    {
        $this->loadMissing('tesList');

        $this->total_soal = (int) $this->tesList->sum('total_soal');
        $this->total_bobot = (int) $this->tesList->sum('total_bobot');
        $this->save();
    }

    public function isGabungan(): bool
    {
        return $this->mode_penilaian === self::MODE_GABUNGAN;
    }

    /**
     * Apakah nilai gabungan (akumulasi) perlu ditampilkan.
     */
    public function tampilkanGabungan(): bool
    {
        return in_array($this->mode_penilaian, [self::MODE_GABUNGAN, self::MODE_KEDUANYA], true);
    }

    /**
     * Apakah rincian nilai per sub-tes perlu ditampilkan.
     */
    public function tampilkanTerpisah(): bool
    {
        return in_array($this->mode_penilaian, [self::MODE_TERPISAH, self::MODE_KEDUANYA], true);
    }
}
