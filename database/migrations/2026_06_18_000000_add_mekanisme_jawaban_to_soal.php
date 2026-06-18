<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan dukungan dua mekanisme penilaian pada tabel `soal` tanpa
     * mengubah/menghapus kolom lama:
     *
     * 1. 'bobot_soal'    => mekanisme lama: 1 bobot untuk seluruh soal
     *                       (kolom `bobot_nilai`), benar = full, salah = 0.
     * 2. 'bobot_jawaban' => setiap pilihan A–E punya bobotnya sendiri
     *                       (kolom `bobot_jawaban_a` .. `bobot_jawaban_e`).
     *                       Skor = bobot dari pilihan yang dipilih member.
     */
    public function up(): void
    {
        if (! Schema::hasTable('soal')) {
            return;
        }

        Schema::table('soal', function (Blueprint $table) {
            if (! Schema::hasColumn('soal', 'mekanisme_jawaban')) {
                // Default 'bobot_soal' agar seluruh data lama tetap memakai mekanisme lama.
                $table->string('mekanisme_jawaban', 20)
                    ->default('bobot_soal')
                    ->after('bobot_nilai');
            }

            foreach (['a', 'b', 'c', 'd', 'e'] as $ab) {
                $col = "bobot_jawaban_{$ab}";
                if (! Schema::hasColumn('soal', $col)) {
                    $table->integer($col)->default(0)->after('mekanisme_jawaban');
                }
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('soal')) {
            return;
        }

        Schema::table('soal', function (Blueprint $table) {
            foreach (['a', 'b', 'c', 'd', 'e'] as $ab) {
                $col = "bobot_jawaban_{$ab}";
                if (Schema::hasColumn('soal', $col)) {
                    $table->dropColumn($col);
                }
            }

            if (Schema::hasColumn('soal', 'mekanisme_jawaban')) {
                $table->dropColumn('mekanisme_jawaban');
            }
        });
    }
};
