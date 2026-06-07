<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = [
        'name',
        'deskripsi',
        'benefit',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'benefit' => 'array',
        ];
    }
    public function profile(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    
}