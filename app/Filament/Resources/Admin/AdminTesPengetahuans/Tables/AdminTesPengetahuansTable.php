<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Tables;

use App\Models\TesPengetahuan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

                TextColumn::make('total_soal')
                    ->label("Jumlah Soal")
                    ->badge()
                    ->color('gray'),

                TextColumn::make('total_bobot')
                    ->label("Total Bobot")
                    ->badge()
                    ->color('warning'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->form([
                        TextInput::make('batas_waktu')
                            ->label('Batas Waktu')
                            ->maxLength(255)
                            ->placeholder('Contoh: 90 Menit'),
                        
                        Toggle::make('is_paid')
                            ->label('Tes Berbayar'),
                            
                        Toggle::make('status')
                            ->label('Aktifkan Soal'),
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
