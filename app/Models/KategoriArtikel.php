<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriArtikel extends Model
{
    //
    protected $table = 'kategori_artikel';
    
    protected $fillable = [
        'title',
    ];

    public function artikel(): HasMany
    {
        return $this->hasMany(artikel::class);
    }
}
