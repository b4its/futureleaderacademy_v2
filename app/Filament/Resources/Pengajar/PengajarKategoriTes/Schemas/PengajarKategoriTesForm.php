<?php

namespace App\Filament\Resources\Pengajar\PengajarKategoriTes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengajarKategoriTesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Cth: TWK, TIU, TKP, Matematika...'),
            ]);
    }
}
