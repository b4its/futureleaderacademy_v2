<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom total_bobot pada tes_pengetahuan (akumulasi seluruh
     * bobot_nilai = skor maksimal tes) tanpa harus migrate:fresh, dan
     * memastikan setiap soal memiliki bobot_nilai minimal 1.
     */
    public function up(): void
    {
        if (Schema::hasTable('tes_pengetahuan') && !Schema::hasColumn('tes_pengetahuan', 'total_bobot')) {
            Schema::table('tes_pengetahuan', function (Blueprint $table) {
                $table->integer('total_bobot')->default(0)->after('total_soal');
            });
        }

        // Pastikan bobot_nilai tidak null pada data lama (default 1).
        if (Schema::hasColumn('soal', 'bobot_nilai')) {
            DB::table('soal')->whereNull('bobot_nilai')->update(['bobot_nilai' => 1]);
        }

        // Hitung ulang total_bobot untuk seluruh tes yang sudah ada.
        if (Schema::hasColumn('tes_pengetahuan', 'total_bobot')) {
            $tesList = DB::table('tes_pengetahuan')->get();
            foreach ($tesList as $tes) {
                $agg = DB::table('soal')
                    ->where('kategori_tes_id', $tes->kategori_tes_id)
                    ->where('tipe_soal_id', $tes->tipe_soal_id)
                    ->selectRaw('COUNT(*) as total_soal, COALESCE(SUM(bobot_nilai), 0) as total_bobot')
                    ->first();

                DB::table('tes_pengetahuan')
                    ->where('id', $tes->id)
                    ->update([
                        'total_soal' => $agg->total_soal,
                        'total_bobot' => $agg->total_bobot,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tes_pengetahuan', 'total_bobot')) {
            Schema::table('tes_pengetahuan', function (Blueprint $table) {
                $table->dropColumn('total_bobot');
            });
        }
    }
};
