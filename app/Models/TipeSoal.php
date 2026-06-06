<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeSoal extends Model
{
    protected $table = 'tipe_soal';
    
    protected $fillable = [
        'pengajar_id',
        'title',
    ];

    public function pengajar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }

    public function soal(): HasMany
    {
        return $this->hasMany(Soal::class);
    }
}