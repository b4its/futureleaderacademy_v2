<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels\Tables;

use App\Models\KategoriArtikel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminKategoriArtikelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                KategoriArtikel::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('kategori_artikel.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->modalHeading('Edit Kategori Artikel'),
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
