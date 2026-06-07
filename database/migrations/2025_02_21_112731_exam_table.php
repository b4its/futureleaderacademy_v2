<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
                //soal model

            Schema::create('kategori_tes', function (Blueprint $table) {
                $table->id();  
                $table->string('title') -> nullable();
                $table->timestamps();
            });

            Schema::create('tes_pengetahuan', function (Blueprint $table) {
                $table->id();  
                $table->foreignId('kategori_tes_id')->nullable()->constrained('kategori_tes')->onDelete('cascade');
                $table->foreignId('tipe_soal_id')->nullable()->constrained('tipe_soal')->onDelete('cascade');
                $table->string('kode_tes')->nullable();
                $table->string('pelajaran')->nullable();
                $table->bigInteger('total_soal')->nullable();
                $table->string('batas_waktu')->nullable();
                $table->boolean('status' ) -> default(0);
                $table->timestamps();
            });
        // }
                
            Schema::create('hasil_tes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');  
                $table->foreignId('kategori_tes_id')->nullable()->constrained('kategori_tes')->onDelete('cascade');
                $table->foreignId('tes_pengetahuan_id')->nullable()->constrained('tes_pengetahuan')->onDelete('cascade');
                $table->bigInteger('jumlah_benar') -> nullable();
                $table->bigInteger('jumlah_salah') -> nullable();
                $table->string('total_nilai') -> nullable();
                $table->dateTime('waktu_dimulai') -> nullable();
                $table->dateTime('waktu_berakhir') -> nullable();
                $table->boolean('status' ) -> default(0);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('hasil_tes');
        Schema::dropIfExists('tes_pengetahuan');
        Schema::dropIfExists('kategori_tes');

    }
};
