<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminKategoriArtikelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Artikel')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')->label('Judul Kategori'),
                        TextEntry::make('artikel_count')
                            ->label('Jumlah Artikel')
                            ->badge()
                            ->color('gray')
                            ->state(fn ($record) => $record->artikel()->count() . ' artikel'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Artikel Terkait')
                    ->schema([
                        RepeatableEntry::make('artikel')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('title')->label('Judul Artikel'),
                            ])
                            ->placeholder('Belum ada artikel.'),
                    ]),
            ]);
    }
}
