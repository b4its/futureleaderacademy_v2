<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengajarTipeSoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Tipe Soal')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Cth: Matematika Dasar Bab 1'),
            ]);
    }
}
