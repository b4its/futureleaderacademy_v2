<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artikel extends Model
{
    //
    protected $table = 'artikel';
    
    protected $fillable = [
        'kategori_artikel_id',
        'title',
        'description',
        'gambar',

    ];

    public function kategoriArtikel(): BelongsTo
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }
}
