<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminAkunMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->with(['profile.kelas']) // Eager load untuk performa dan menghindari N+1
                    ->where('role', 'member')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                // Gunakan fitur bawaan Filament untuk penomoran baris
                TextColumn::make('No')
                    ->rowIndex(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('profile.kelas.name')
                    ->label('Paket Kelas')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->modalHeading('Edit Member'),
                DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('Apakah yakin ingin menghapus data ini?')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}