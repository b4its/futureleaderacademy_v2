<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Soal extends Model
{
    protected $table = 'soal';
    
    protected $fillable = [
        'user_id',
        'pengajar_id',
        'tipe_soal_id',
        'kategori_tes_id',
        'pertanyaan',
        'visual_pertanyaan',
        'jawaban_a',
        'jawaban_b',
        'jawaban_c',
        'jawaban_d',
        'jawaban_e',
        'visual_jawaban_a',
        'visual_jawaban_b',
        'visual_jawaban_c',
        'visual_jawaban_d',
        'visual_jawaban_e',
        'jawaban_benar',
        'bobot_nilai',
        'total_bobot'  
    ];

    /**
     * Saat soal disimpan/diubah/dihapus, hitung ulang total_soal & total_bobot
     * pada TesPengetahuan terkait agar skor maksimal tes selalu sinkron.
     */
    protected static function booted(): void
    {
        $sync = function (Soal $soal) {
            // Sinkron untuk kombinasi saat ini.
            self::syncTesPengetahuan($soal->kategori_tes_id, $soal->tipe_soal_id);

            // Jika kategori/tipe berubah, sinkron juga kombinasi lama.
            if ($soal->isDirty(['kategori_tes_id', 'tipe_soal_id'])) {
                self::syncTesPengetahuan(
                    $soal->getOriginal('kategori_tes_id'),
                    $soal->getOriginal('tipe_soal_id')
                );
            }
        };

        static::saved($sync);
        static::deleted($sync);
    }

    /**
     * Hitung ulang total_soal & total_bobot pada TesPengetahuan
     * untuk pasangan kategori_tes_id + tipe_soal_id tertentu.
     */
    protected static function syncTesPengetahuan($kategoriTesId, $tipeSoalId): void
    {
        if (empty($kategoriTesId) || empty($tipeSoalId)) {
            return;
        }

        $tes = TesPengetahuan::where('kategori_tes_id', $kategoriTesId)
            ->where('tipe_soal_id', $tipeSoalId)
            ->first();

        if (!$tes) {
            return;
        }

        $query = self::where('kategori_tes_id', $kategoriTesId)
            ->where('tipe_soal_id', $tipeSoalId);

        $tes->total_soal = $query->count();
        $tes->total_bobot = (int) $query->sum('bobot_nilai');
        $tes->save();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengajar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }

    public function tipeSoal(): BelongsTo
    {
        return $this->belongsTo(TipeSoal::class);
    }

    public function kategoriTes(): BelongsTo
    {
        return $this->belongsTo(KategoriTes::class);
    }
}