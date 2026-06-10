<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminArtikelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')->label('Judul')->columnSpanFull(),
                        TextEntry::make('kategoriArtikel.title')->label('Kategori')->placeholder('-'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                        ImageEntry::make('gambar')
                            ->label('Gambar')
                            ->disk('public_folder')
                            ->placeholder('Tidak ada gambar')
                            ->columnSpanFull(),
                    ]),

                Section::make('Isi Artikel')
                    ->schema([
                        TextEntry::make('description')
                            ->hiddenLabel()
                            ->html()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
