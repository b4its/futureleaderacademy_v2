<?php

namespace App\Filament\Resources\Admin\AdminHasilTes\Tables;

use App\Models\HasilTes;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminHasilTesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                HasilTes::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('hasil_tes.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('tesPengetahuan.pelajaran')->label("Pelajaran"),
                TextColumn::make('paketTes.nama')->label("Paket")->placeholder('—')->badge()->color('info'),
                TextColumn::make('total_nilai')->label("Total Nilai"),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
