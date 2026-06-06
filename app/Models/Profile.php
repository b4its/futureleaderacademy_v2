<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'profile';
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'kelas',
        'gambar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}