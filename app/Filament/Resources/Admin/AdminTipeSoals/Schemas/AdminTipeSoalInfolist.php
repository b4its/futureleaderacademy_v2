<?php

namespace App\Filament\Resources\Admin\AdminTipeSoals\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminTipeSoalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tipe Soal')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')->label('Judul Tipe Soal'),
                        TextEntry::make('pengajar.name')->label('Pengajar')->placeholder('-'),
                        TextEntry::make('soal_count')
                            ->label('Jumlah Soal')
                            ->badge()
                            ->color('gray')
                            ->state(fn ($record) => $record->soal()->count() . ' soal'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Soal Terkait')
                    ->schema([
                        RepeatableEntry::make('soal')
                            ->hiddenLabel()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('pertanyaan')->label('Pertanyaan')->html()->placeholder('(Soal bergambar)')->columnSpan(2),
                                TextEntry::make('jawaban_benar')->label('Kunci')->badge()->color('success'),
                            ])
                            ->placeholder('Belum ada soal.'),
                    ]),
            ]);
    }
}
