<?php

namespace App\Filament\Resources\Admin\AdminPakets\Tables;

use App\Models\Kelas;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminPaketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Kelas::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('kelas.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Paket')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('idr', divideBy: 0, decimalPlaces: 0)
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->modalHeading('Edit Paket'),
                DeleteAction::make()
                    ->button()
                    ->color('danger') // default abu-abu (tidak merah)
                    ->requiresConfirmation() // pastikan tampil popup konfirmasi
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('apakah yakin ingin menghapus data ini?')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
