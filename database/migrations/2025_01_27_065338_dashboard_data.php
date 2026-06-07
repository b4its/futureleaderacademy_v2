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
        // Create Dashboard Data
        Schema::create('banner', function (Blueprint $table) {
            $table->id();
            $table->string('gambar') -> nullable();
            $table->timestamps();
        });

        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pengguna') -> nullable();
            $table->string('pesan') -> nullable();
            $table->string('kota_asal') -> nullable();
            $table->string('pencapaian') -> nullable();
            $table->boolean('status' ) -> default(0);
            
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();                                                                            
            $table->string('name') -> nullable();
            $table->string('deskripsi') -> nullable();
            $table->json('benefit') -> nullable(); // Menyimpan array dalam kolom JSON
            $table->decimal('harga', 25, 2)->default(0); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Action if exists it will dropped
        Schema::dropIfExists('banner');
        Schema::dropIfExists('testimoni');
        Schema::dropIfExists('kelas');
    }
};
