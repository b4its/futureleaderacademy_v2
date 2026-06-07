<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminAkunPengajarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('users.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->where('role', '=', 'pengajar') // Exclude admin from the list
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->modalHeading('Edit Pengajar')
                    
                    // 1. Tarik data dari relasi profile saat modal EDIT dibuka
                    ->mutateRecordDataUsing(function (array $data, Model $record): array {
                        if ($record->profile) {
                            $data['first_name'] = $record->profile->first_name;
                            $data['last_name'] = $record->profile->last_name;
                            $data['bidang_ilmu'] = $record->profile->bidang_ilmu;
                        }
                        return $data;
                    })
                    
                    // 2. Simpan data ke tabel yang benar saat tombol Save ditekan
                    ->using(function (Model $record, array $data): Model {
                        return DB::transaction(function () use ($record, $data) {
                            // Tangkap data profil
                            $profileData = [
                                'first_name'  => $data['first_name'] ?? null,
                                'last_name'   => $data['last_name'] ?? null,
                                'bidang_ilmu' => $data['bidang_ilmu'] ?? null,
                            ];

                            // Buang dari $data utama agar tidak error "column not found" di tabel users
                            unset($data['first_name'], $data['last_name'], $data['bidang_ilmu']);

                            // Update data user (name, email, password jika diisi)
                            $record->update($data);

                            // Update data relasi profil
                            $record->profile()->update($profileData);

                            return $record;
                        });
                    }),
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
