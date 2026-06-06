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
        Schema::create('tipe_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajar_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title') -> nullable();
            $table->timestamps();
        });
 
        //soal model
        Schema::create('soal', function (Blueprint $table) {
            $table->id();  
            // Relasi Utama
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajar_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('tipe_soal_id')->nullable()->constrained('tipe_soal')->onDelete('cascade');
            
            // Informasi Soal
            $table->text('pertanyaan')->nullable(); // Diubah ke TEXT agar muat teks panjang
            $table->string('visual_pertanyaan')->nullable(); // Menyimpan path/url gambar pertanyaan

            // Pilihan Jawaban Teks
            $table->text('jawaban_a')->nullable();
            $table->text('jawaban_b')->nullable();
            $table->text('jawaban_c')->nullable();
            $table->text('jawaban_d')->nullable();
            $table->text('jawaban_e')->nullable();

            // Pilihan Jawaban Gambar/Visual (Jika ada)
            $table->string('visual_jawaban_a')->nullable();
            $table->string('visual_jawaban_b')->nullable();
            $table->string('visual_jawaban_c')->nullable();
            $table->string('visual_jawaban_d')->nullable();
            $table->string('visual_jawaban_e')->nullable();

            // Kunci & Nilai
            $table->char('jawaban_benar', 2)->nullable(); // Cukup panjang 2 (misal: 'A', 'B')
            $table->integer('bobot_nilai')->nullable(); // Mengikuti snake_case standar Laravel & diubah ke integer
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tipe_soal');
        Schema::dropIfExists('soal');
        

    }
};
