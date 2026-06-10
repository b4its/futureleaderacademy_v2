<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminAkunPengajarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun Pengajar')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nama Pengajar'),
                        TextEntry::make('email')->label('Email')->copyable(),
                        TextEntry::make('role')->label('Role')->badge()->color('warning'),
                        TextEntry::make('created_at')->label('Terdaftar')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Statistik Pengajaran')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('jumlah_tipe_soal')
                            ->label('Jumlah Tipe Soal')
                            ->badge()
                            ->color('primary')
                            ->state(fn ($record) => \App\Models\TipeSoal::where('pengajar_id', $record->id)->count() . ' tipe'),

                        TextEntry::make('jumlah_soal')
                            ->label('Total Soal Dibuat')
                            ->badge()
                            ->color('info')
                            ->state(fn ($record) => \App\Models\Soal::where('pengajar_id', $record->id)->count() . ' soal'),

                        TextEntry::make('jumlah_tes')
                            ->label('Total Tes')
                            ->badge()
                            ->color('success')
                            ->state(function ($record) {
                                $tipeSoalIds = \App\Models\TipeSoal::where('pengajar_id', $record->id)->pluck('id');
                                return \App\Models\TesPengetahuan::whereIn('tipe_soal_id', $tipeSoalIds)->count() . ' tes';
                            }),
                    ]),
            ]);
    }
}
