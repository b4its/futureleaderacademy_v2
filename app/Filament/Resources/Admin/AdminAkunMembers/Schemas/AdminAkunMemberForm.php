<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class AdminAkunMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->required()
                    ->live(debounce: 500) // Re-render setelah user berhenti ngetik 0.5 detik
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        // Gabungkan first_name dan last_name
                        $set('name', trim($get('first_name') . ' ' . $get('last_name')));
                    }),

                TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        // Gabungkan first_name dan last_name
                        $set('name', trim($get('first_name') . ' ' . $get('last_name')));
                    }),

                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->readOnly() // Buat read-only agar user tidak mengedit manual (opsional)
                    ->helperText('Diisi otomatis berdasarkan Nama Depan dan Nama Belakang.'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Select::make('profile.kelas_id')
                    ->label('Paket')
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