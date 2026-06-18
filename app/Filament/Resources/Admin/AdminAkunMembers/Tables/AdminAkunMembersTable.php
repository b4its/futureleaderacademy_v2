<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

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
                    ->default('pengguna bukan member')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                ->modalHeading('Edit Member')
                // Hapus tulisan "Model" di bawah ini, sisakan $record saja
                ->using(function ($record, array $data): \Illuminate\Database\Eloquent\Model {
                    return DB::transaction(function () use ($record, $data) {
                        
                        $profileData = $data['profile'] ?? [];
                        unset($data['profile']);
            
                        $record->update($data);
            
                        if ($record->profile && !empty($profileData)) {
                            $record->profile->update([
                                'first_name' => $profileData['first_name'] ?? null,
                                'last_name' => $profileData['last_name'] ?? null,
                                'kelas_id' => $profileData['kelas_id'] ?? null,
                            ]);
                        }
            
                        return $record;
                    });
                }),
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