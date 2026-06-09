<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class AdminAkunPengajarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('name', trim($get('first_name') . ' ' . $get('last_name')));
                    }),

                TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('name', trim($get('first_name') . ' ' . $get('last_name')));
                    }),

                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->readOnly()
                    ->helperText('Diisi otomatis berdasarkan Nama Depan dan Nama Belakang.'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(fn (string $operation): bool => $operation === 'create'),
                
                // Hapus 'profile.' agar konsisten dan mudah ditangkap di controller
                TextInput::make('bidang_ilmu')
                    ->label('Bidang Ilmu')
                    ->required(fn (string $operation): bool => $operation === 'create'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state)),
            ]);
    }
}
