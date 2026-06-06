<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = [
        'name',
        'gambar',
        'deskripsi',
        'benefit',
    ];

    protected function casts(): array
    {
        return [
            'benefit' => 'array',
        ];
    }
}