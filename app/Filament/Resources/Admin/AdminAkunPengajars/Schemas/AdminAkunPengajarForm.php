<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminAkunPengajarForm
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
                TextInput::make('bidang_ilmu')
                    ->label('Bidang Ilmu')
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
