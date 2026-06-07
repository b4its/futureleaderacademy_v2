<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminAkunMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Select::make('profile.kelas_id')
                    ->label('Paket')
                    // Gunakan nama fungsi relasi di Model Pesanan yang baru saja kita ubah
                    ->relationship('profile.kelas', 'name') 
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state)),
            ]);
    }
}
