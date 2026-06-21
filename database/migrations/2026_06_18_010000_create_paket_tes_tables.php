<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fitur "Paket Tes": menggabungkan beberapa tes_pengetahuan menjadi satu
     * paket (mis. "UTBK STAN" = tes1 + tes2 + tes3). Saat dikerjakan, soal
     * seluruh sub-tes digabung jadi satu sesi, tetapi penilaian dicatat
     * PER sub-tes. Tersedia dua mode penilaian:
     *   - 'terpisah'  : nilai tiap sub-tes ditampilkan terpisah (tidak digabung).
     *   - 'gabungan'  : nilai seluruh sub-tes diakumulasi menjadi satu nilai.
     *
     * Migration ini hanya MENAMBAH tabel/kolom baru, tidak mengubah skema lama.
     */
    public function up(): void
    {
        // 1. Header paket.
        if (! Schema::hasTable('paket_tes')) {
            Schema::create('paket_tes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengajar_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('nama');
                $table->string('kode_paket')->nullable();
                $table->text('deskripsi')->nullable();
                // 'terpisah' | 'gabungan'
                $table->string('mode_penilaian', 20)->default('terpisah');
                // total waktu pengerjaan seluruh paket (menit). null = tanpa batas.
                $table->integer('batas_waktu')->nullable();
                $table->tinyInteger('is_paid')->default(1);
                $table->tinyInteger('status')->default(1);
                // akumulasi dari seluruh sub-tes (cache, agar tidak hitung berulang).
                $table->integer('total_soal')->default(0);
                $table->integer('total_bobot')->default(0);
                $table->timestamps();
            });
        }

        // 2. Pivot paket <-> tes_pengetahuan (sub-tes) dengan urutan.
        if (! Schema::hasTable('paket_tes_tes')) {
            Schema::create('paket_tes_tes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('paket_tes_id')->constrained('paket_tes')->onDelete('cascade');
                $table->foreignId('tes_pengetahuan_id')->constrained('tes_pengetahuan')->onDelete('cascade');
                $table->integer('urutan')->default(0);
                $table->timestamps();

                $table->unique(['paket_tes_id', 'tes_pengetahuan_id'], 'paket_tes_unique');
            });
        }

        // 3. Header hasil pengerjaan paket (satu baris per sesi pengerjaan).
        if (! Schema::hasTable('paket_tes_hasil')) {
            Schema::create('paket_tes_hasil', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('paket_tes_id')->nullable()->constrained('paket_tes')->onDelete('cascade');
                // snapshot mode saat dikerjakan (agar tampilan hasil tetap konsisten).
                $table->string('mode_penilaian', 20)->default('terpisah');
                // akumulasi seluruh sub-tes (untuk mode gabungan / ringkasan).
                $table->string('total_nilai')->nullable();
                $table->integer('total_bobot')->default(0);
                $table->bigInteger('jumlah_benar')->nullable();
                $table->bigInteger('jumlah_salah')->nullable();
                $table->dateTime('waktu_dimulai')->nullable();
                $table->dateTime('waktu_berakhir')->nullable();
                $table->boolean('status')->default(0); // 0 = berjalan, 1 = selesai
                $table->timestamps();
            });
        }

        // 4. Tautkan hasil_tes (per sub-tes) ke sesi paket bila dikerjakan via paket.
        Schema::table('hasil_tes', function (Blueprint $table) {
            if (! Schema::hasColumn('hasil_tes', 'paket_tes_id')) {
                $table->unsignedBigInteger('paket_tes_id')->nullable()->after('tes_pengetahuan_id');
            }
            if (! Schema::hasColumn('hasil_tes', 'paket_tes_hasil_id')) {
                $table->unsignedBigInteger('paket_tes_hasil_id')->nullable()->after('paket_tes_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            foreach (['paket_tes_hasil_id', 'paket_tes_id'] as $col) {
                if (Schema::hasColumn('hasil_tes', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('paket_tes_hasil');
        Schema::dropIfExists('paket_tes_tes');
        Schema::dropIfExists('paket_tes');
    }
};
