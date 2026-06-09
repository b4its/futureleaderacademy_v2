<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Schemas;

use App\Models\Kelas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminAkunMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Nama yang tampil di sistem.'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(fn (string $operation): bool => $operation === 'create'),

                Select::make('profile.kelas_id')
                    ->label('Paket / Kelas')
                    ->options(fn () => Kelas::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
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
