<?php

namespace App\Filament\Resources\Admin\AdminPakets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminPaketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Paket / Kelas')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nama Paket'),
                        TextEntry::make('harga')
                            ->label('Harga')
                            ->state(fn ($record) => 'Rp ' . number_format((float) $record->harga, 0, ',', '.')),
                        TextEntry::make('member_count')
                            ->label('Jumlah Member')
                            ->badge()
                            ->color('gray')
                            ->state(fn ($record) => $record->profile()->count() . ' member'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Deskripsi')
                    ->schema([
                        TextEntry::make('deskripsi')
                            ->hiddenLabel()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
