<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PengajarPaketTesHasilInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ringkasan Pengerjaan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('user.name')->label('Peserta'),
                        TextEntry::make('paketTes.nama')->label('Paket'),
                        TextEntry::make('mode_penilaian')
                            ->label('Mode')
                            ->badge()
                            ->formatStateUsing(fn ($state) => \App\Models\PaketTes::modeLabel($state))
                            ->color(fn ($state) => match ($state) {
                                'gabungan' => 'info',
                                'keduanya' => 'warning',
                                default => 'success',
                            }),
                        TextEntry::make('total_nilai')->label('Nilai Gabungan')->badge()->color('primary'),
                        TextEntry::make('total_bobot')->label('Skor Maksimal'),
                        TextEntry::make('jumlah_benar')->label('Total Benar')->color('success'),
                        TextEntry::make('jumlah_salah')->label('Total Salah')->color('danger'),
                        TextEntry::make('waktu_dimulai')->label('Mulai')->dateTime('d M Y, H:i'),
                        TextEntry::make('waktu_berakhir')->label('Selesai')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Rincian Nilai per Sub-Tes')
                    ->schema([
                        RepeatableEntry::make('detail')
                            ->hiddenLabel()
                            ->columns(4)
                            ->schema([
                                TextEntry::make('tesPengetahuan.pelajaran')->label('Sub-Tes')->columnSpan(2),
                                TextEntry::make('total_nilai')->label('Nilai')->badge()->color('primary'),
                                TextEntry::make('jumlah_benar')->label('Benar')->color('success'),
                            ])
                            ->placeholder('Tidak ada rincian.'),
                    ]),
            ]);
    }
}
