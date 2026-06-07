<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Schemas;

use Dom\Text;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminArtikelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('kategori_artikel_id')
                    ->label('Kategori Artikel')
                    // Gunakan nama fungsi relasi di Model Pesanan yang baru saja kita ubah
                    ->relationship('kategoriArtikel', 'title') 
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->label('Isi Artikel')
                    ->columnSpanFull()
                    ->required(),
                
            ]);
    }
}
