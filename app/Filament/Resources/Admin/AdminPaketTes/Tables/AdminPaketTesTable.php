<?php

namespace App\Filament\Resources\Admin\AdminPaketTes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminPaketTesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kode_paket')
                    ->label('Kode')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('mode_penilaian')
                    ->label('Mode')
                    ->badge()
                    ->formatStateUsing(fn ($state) => \App\Models\PaketTes::modeLabel($state))
                    ->color(fn ($state) => match ($state) {
                        'gabungan' => 'info',
                        'keduanya' => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('tes_list_count')
                    ->label('Sub-Tes')
                    ->counts('tesList')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('total_soal')
                    ->label('Total Soal')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('hasil_count')
                    ->label('Pengerjaan')
                    ->counts('hasil')
                    ->badge()
                    ->color('warning'),

                IconColumn::make('status')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('Menghapus paket tidak menghapus sub-tes, hanya membatalkan penggabungannya.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
