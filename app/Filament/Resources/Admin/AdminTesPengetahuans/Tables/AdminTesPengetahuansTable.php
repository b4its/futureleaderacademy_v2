<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Tables;

use App\Models\TesPengetahuan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminTesPengetahuansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                TesPengetahuan::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('tes_pengetahuan.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('kode_tes')->label("Kode Tes"),
                TextColumn::make('kategoriTes.title')->label("Jenis Tes"),

                TextColumn::make('pelajaran')->label("Pelajaran"),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
