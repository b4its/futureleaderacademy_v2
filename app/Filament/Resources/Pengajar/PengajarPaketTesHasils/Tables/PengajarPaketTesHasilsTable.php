<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajarPaketTesHasilsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('status', 1))
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('paketTes.nama')
                    ->label('Paket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mode_penilaian')
                    ->label('Mode')
                    ->badge()
                    ->formatStateUsing(fn ($state) => \App\Models\PaketTes::modeLabel($state))
                    ->color(fn ($state) => match ($state) {
                        'gabungan' => 'info',
                        'keduanya' => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('total_nilai')
                    ->label('Nilai Gabungan')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('total_bobot')->label('Maks'),

                TextColumn::make('jumlah_benar')->label('Benar')->color('success'),
                TextColumn::make('jumlah_salah')->label('Salah')->color('danger'),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('paket_tes_id')
                    ->label('Filter Paket')
                    ->relationship('paketTes', 'nama'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make()->label('Lihat Rincian'),
            ])
            ->toolbarActions([]);
    }
}
