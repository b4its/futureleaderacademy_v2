<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Schemas;

use Filament\Forms\Components\FileUpload;
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
                Select::make('kategori_artikel_id')
                    ->label('Kategori Artikel')
                    ->relationship('kategoriArtikel', 'title') 
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('gambar')
                    ->label('Gambar Artikel')
                    ->image()
                    ->directory('artikel')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                RichEditor::make('description')
                    ->label('Isi Artikel')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'orderedList',
                        'bulletList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                        'redo',
                        'undo',
                    ])
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
