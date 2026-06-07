<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';
    
    protected $fillable = [
        'user_id',
        'kategori_tes_id',
        'tes_pengetahuan_id',
        'jumlah_benar',
        'jumlah_salah',
        'total_nilai',
        'waktu_dimulai',
        'waktu_berakhir',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'waktu_dimulai' => 'datetime',
            'waktu_berakhir' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tesPengetahuan(): BelongsTo
    {
        return $this->belongsTo(TesPengetahuan::class);
    }
}