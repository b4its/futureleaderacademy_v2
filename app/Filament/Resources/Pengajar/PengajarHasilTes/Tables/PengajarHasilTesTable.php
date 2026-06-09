<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajarHasilTesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tesPengetahuan.pelajaran')
                    ->label('Tes')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('jumlah_benar')
                    ->label('Benar')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('jumlah_salah')
                    ->label('Salah')
                    ->sortable()
                    ->color('danger'),

                TextColumn::make('total_nilai')
                    ->label('Nilai')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        floatval($state) >= 75 => 'success',
                        floatval($state) >= 50 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('waktu_dimulai')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('waktu_berakhir')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tes_pengetahuan_id')
                    ->label('Filter Tes')
                    ->relationship('tesPengetahuan', 'pelajaran'),
            ])
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc');
    }
}
