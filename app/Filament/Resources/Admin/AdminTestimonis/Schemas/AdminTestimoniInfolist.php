<?php

namespace App\Filament\Resources\Admin\AdminTestimonis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminTestimoniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Testimoni')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_pengguna')->label('Nama Pengguna')->placeholder('-'),
                        TextEntry::make('kota_asal')->label('Kota Asal')->placeholder('-'),
                        TextEntry::make('pencapaian')->label('Pencapaian')->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Status Tampil')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Ditampilkan' : 'Disembunyikan')
                            ->color(fn ($record) => $record->status ? 'success' : 'danger'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Pesan')
                    ->schema([
                        TextEntry::make('pesan')
                            ->hiddenLabel()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
