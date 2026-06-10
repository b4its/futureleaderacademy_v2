<?php

namespace App\Filament\Resources\Admin\AdminHasilTes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminHasilTesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Hasil Tes')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')->label('Peserta')->placeholder('-'),
                        TextEntry::make('user.email')->label('Email')->placeholder('-'),
                        TextEntry::make('tesPengetahuan.pelajaran')->label('Pelajaran / Tes')->placeholder('-'),
                        TextEntry::make('tesPengetahuan.kode_tes')->label('Kode Tes')->badge()->color('primary')->placeholder('-'),
                        TextEntry::make('kategoriTes.title')->label('Kategori')->placeholder('-'),
                        TextEntry::make('total_nilai')->label('Nilai Diperoleh')->badge()->color('info'),
                        TextEntry::make('jumlah_benar')
                            ->label('Benar')
                            ->badge()
                            ->color('success')
                            ->state(fn ($record) => $record->jumlah_benar . ' soal'),
                        TextEntry::make('jumlah_salah')
                            ->label('Salah')
                            ->badge()
                            ->color('danger')
                            ->state(fn ($record) => $record->jumlah_salah . ' soal'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Selesai' : 'Belum Selesai')
                            ->color(fn ($record) => $record->status ? 'success' : 'warning'),
                        TextEntry::make('waktu_dimulai')->label('Waktu Mulai')->dateTime('d M Y, H:i'),
                        TextEntry::make('waktu_berakhir')->label('Waktu Selesai')->dateTime('d M Y, H:i'),
                        TextEntry::make('created_at')->label('Dicatat')->dateTime('d M Y, H:i'),
                    ]),
            ]);
    }
}
