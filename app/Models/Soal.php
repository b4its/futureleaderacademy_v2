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
        'mekanisme_jawaban',
        'bobot_jawaban_a',
        'bobot_jawaban_b',
        'bobot_jawaban_c',
        'bobot_jawaban_d',
        'bobot_jawaban_e',
        'total_bobot'  
    ];

    /**
     * Mekanisme penilaian yang didukung.
     * - bobot_soal    : 1 bobot untuk seluruh soal (kolom bobot_nilai).
     * - bobot_jawaban : tiap pilihan A–E punya bobot sendiri.
     */
    public const MEKANISME_BOBOT_SOAL = 'bobot_soal';
    public const MEKANISME_BOBOT_JAWABAN = 'bobot_jawaban';

    /**
     * Skor maksimal yang dapat diperoleh dari soal ini.
     * - bobot_soal    : sama dengan bobot_nilai.
     * - bobot_jawaban : bobot tertinggi di antara pilihan A–E.
     */
    public function getSkorMaksimalAttribute(): int
    {
        if ($this->mekanisme_jawaban === self::MEKANISME_BOBOT_JAWABAN) {
            return (int) max(
                (int) $this->bobot_jawaban_a,
                (int) $this->bobot_jawaban_b,
                (int) $this->bobot_jawaban_c,
                (int) $this->bobot_jawaban_d,
                (int) $this->bobot_jawaban_e,
            );
        }

        return (int) $this->bobot_nilai;
    }

    /**
     * Skor yang diperoleh bila member memilih pilihan $huruf (A–E).
     * - bobot_soal    : full bobot_nilai bila $huruf == jawaban_benar, selain itu 0.
     * - bobot_jawaban : bobot dari pilihan yang dipilih.
     */
    public function skorUntukPilihan(?string $huruf): int
    {
        $huruf = strtoupper((string) $huruf);

        if ($this->mekanisme_jawaban === self::MEKANISME_BOBOT_JAWABAN) {
            $lower = strtolower($huruf);
            if (in_array($lower, ['a', 'b', 'c', 'd', 'e'], true)) {
                return (int) $this->{"bobot_jawaban_{$lower}"};
            }
            return 0;
        }

        return $huruf === strtoupper((string) $this->jawaban_benar)
            ? (int) $this->bobot_nilai
            : 0;
    }

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
        $tes->total_bobot = self::hitungTotalBobot($kategoriTesId, $tipeSoalId);
        $tes->save();
    }

    /**
     * Akumulasi skor maksimal seluruh soal pada pasangan kategori + tipe,
     * dengan mempertimbangkan mekanisme penilaian masing-masing soal.
     */
    public static function hitungTotalBobot($kategoriTesId, $tipeSoalId): int
    {
        $soalList = self::where('kategori_tes_id', $kategoriTesId)
            ->where('tipe_soal_id', $tipeSoalId)
            ->get([
                'mekanisme_jawaban', 'bobot_nilai',
                'bobot_jawaban_a', 'bobot_jawaban_b', 'bobot_jawaban_c',
                'bobot_jawaban_d', 'bobot_jawaban_e',
            ]);

        return (int) $soalList->sum(fn (Soal $soal) => $soal->skor_maksimal);
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