<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminKategoriTesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Tes')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')->label('Judul Kategori'),
                        TextEntry::make('tes_pengetahuan_count')
                            ->label('Jumlah Tes')
                            ->badge()
                            ->color('gray')
                            ->state(fn ($record) => $record->tesPengetahuan()->count() . ' tes'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Tes Pengetahuan Terkait')
                    ->schema([
                        RepeatableEntry::make('tesPengetahuan')
                            ->hiddenLabel()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('pelajaran')->label('Pelajaran'),
                                TextEntry::make('kode_tes')->label('Kode')->badge()->color('primary'),
                                TextEntry::make('total_soal')->label('Jumlah Soal')->suffix(' soal'),
                            ])
                            ->placeholder('Belum ada tes.'),
                    ]),
            ]);
    }
}
