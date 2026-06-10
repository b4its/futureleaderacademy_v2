<?php

namespace App\Filament\Resources\Admin\AdminSoals\Tables;

use App\Models\Soal;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminSoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Soal::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('soal.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('pengajar.name')
                    ->label('Nama Pengajar')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tipeSoal.title')
                    ->label('Tipe Soal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pertanyaan')
                    ->label('pertanyaan')
                    ->html()
                    ->searchable(),
                TextColumn::make('jawaban_benar')
                    ->label('Jawaban Benar')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->modalHeading('Edit Soal'),
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
