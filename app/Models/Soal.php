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
    ];

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
}