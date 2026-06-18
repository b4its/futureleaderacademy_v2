<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        // Cek apakah user memiliki relasi profile dan gambarnya tidak null
        if ($this->profile && $this->profile->gambar) {
            return asset('storage/' . $this->profile->gambar);
        }else {
            return asset('assets/default_user.webp');

        }

        // Return null agar Filament otomatis membuat avatar inisial nama (fallback)
        return null; 
    }

    protected static function booted(): void
    {
        static::created(function ($user) {
            $user->profile()->create([
                'kelas_id' => null,
                'first_name' => null,
                'last_name' => null,
                'gambar' => null,
            ]);
        });
        static::deleting(function (User $user) {
            $user->profile()->delete();
        });
    }

}