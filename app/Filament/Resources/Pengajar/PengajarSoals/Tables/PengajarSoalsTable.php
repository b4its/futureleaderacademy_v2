<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajarSoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->pertanyaan),

                TextColumn::make('tipeSoal.title')
                    ->label('Tipe Soal')
                    ->sortable()
                    ->badge(),

                TextColumn::make('kategoriTes.title')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('jawaban_benar')
                    ->label('Kunci')
                    ->badge()
                    ->color('success'),

                ImageColumn::make('visual_pertanyaan')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(null),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tipe_soal_id')
                    ->label('Tipe Soal')
                    ->relationship('tipeSoal', 'title'),

                SelectFilter::make('kategori_tes_id')
                    ->label('Kategori')
                    ->relationship('kategoriTes', 'title'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
