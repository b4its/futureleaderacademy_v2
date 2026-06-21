<?php

namespace App\Filament\Member\Resources\Member\MemberHasilTes\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MemberHasilTesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('tesPengetahuan.pelajaran')
                    ->label('Pelajaran')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('paketTes.nama')
                    ->label('Paket')
                    ->placeholder('—')
                    ->badge()
                    ->color('info'),

                TextColumn::make('jumlah_benar')
                    ->label('Benar')
                    ->numeric()
                    ->alignCenter()
                    ->color('success'),

                TextColumn::make('jumlah_salah')
                    ->label('Salah')
                    ->numeric()
                    ->alignCenter()
                    ->color('danger'),

                TextColumn::make('total_nilai')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->weight('bold')
                    ->color(fn ($state) => $state >= 70 ? 'success' : 'danger'),

                TextColumn::make('waktu_dimulai')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Selesai' : 'Belum Selesai')
                    ->color(fn ($state) => $state ? 'success' : 'warning'),
            ])
            ->defaultSort('waktu_dimulai', 'desc');
    }
}
