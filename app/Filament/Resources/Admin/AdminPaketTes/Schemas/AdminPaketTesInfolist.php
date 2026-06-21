<?php

namespace App\Filament\Resources\Admin\AdminPaketTes\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminPaketTesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Paket')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama')->label('Nama Paket'),
                        TextEntry::make('kode_paket')->label('Kode')->badge()->color('primary'),
                        TextEntry::make('mode_penilaian')
                            ->label('Mode Penilaian')
                            ->badge()
                            ->formatStateUsing(fn ($state) => \App\Models\PaketTes::modeLabel($state))
                            ->color(fn ($state) => match ($state) {
                                'gabungan' => 'info',
                                'keduanya' => 'warning',
                                default => 'success',
                            }),
                        TextEntry::make('batas_waktu')->label('Batas Waktu')->suffix(' menit')->placeholder('-'),
                        TextEntry::make('total_soal')->label('Total Soal')->badge()->color('gray'),
                        TextEntry::make('total_bobot')->label('Total Bobot')->badge()->color('warning'),
                    ]),

                Section::make('Sub-Tes')
                    ->schema([
                        RepeatableEntry::make('tesList')
                            ->hiddenLabel()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('pelajaran')->label('Sub-Tes'),
                                TextEntry::make('total_soal')->label('Soal')->suffix(' soal'),
                                TextEntry::make('total_bobot')->label('Bobot')->badge()->color('warning'),
                            ])
                            ->placeholder('Belum ada sub-tes.'),
                    ]),
            ]);
    }
}
