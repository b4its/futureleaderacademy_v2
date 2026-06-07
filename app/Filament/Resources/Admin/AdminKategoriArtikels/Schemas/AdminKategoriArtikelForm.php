<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminKategoriArtikelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')
                    ->label('Kategori Artikel')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
