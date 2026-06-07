<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'profile';
    
    protected $fillable = [
        'user_id',
        'kelas_id',
        'first_name',
        'last_name',
        'gambar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}