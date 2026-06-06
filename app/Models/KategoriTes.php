<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTes extends Model
{
    protected $table = 'kategori_tes';
    
    protected $fillable = [
        'title',
    ];

    public function tesPengetahuan(): HasMany
    {
        return $this->hasMany(TesPengetahuan::class);
    }
}