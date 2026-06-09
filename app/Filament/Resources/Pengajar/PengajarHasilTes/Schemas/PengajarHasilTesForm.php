<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengajarHasilTesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('total_nilai')
                    ->label('Nilai')
                    ->disabled(),
            ]);
    }
}
