<?php

namespace App\Filament\Resources\Admin\AdminTestimonis\Tables;

use App\Models\Testimoni;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminTestimonisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Testimoni::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('testimoni.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('nama_pengguna')
                    ->label('Nama Pengguna')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('kota_asal')
                    ->label('Kota Asal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pencapaian')
                    ->label('Pencapaian')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->modalHeading('Edit Testimoni'),
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
