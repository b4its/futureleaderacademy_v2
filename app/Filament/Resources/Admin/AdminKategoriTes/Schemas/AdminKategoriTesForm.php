<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminKategoriTesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')
                    ->label('Kategori Tes')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
