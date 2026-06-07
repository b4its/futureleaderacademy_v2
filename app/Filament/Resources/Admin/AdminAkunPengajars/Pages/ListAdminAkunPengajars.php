<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Pages;

use App\Filament\Resources\Admin\AdminAkunPengajars\AdminAkunPengajarResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListAdminAkunPengajars extends ListRecords
{
    protected static string $resource = AdminAkunPengajarResource::class;
    protected static ?string $title = "Daftar Pengajar";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Pengajar')
            ->modalHeading('Tambahkan Pengajar')
            ->mutateFormDataUsing(function (array $data): array {
                    $data['role'] = "pengajar";
                    return $data;
                })
            ->using(function (array $data, string $model): Model {
                    return DB::transaction(function () use ($data, $model) {

                        // 1. Tangkap SEMUA data profil dari form
                        $firstName = $data['first_name'] ?? null;
                        $lastName = $data['last_name'] ?? null;
                        $bidangIlmu = $data['bidang_ilmu'] ?? null; // <- Tangkap field baru

                        // 2. Buang dari array $data agar tidak error saat create User
                        unset($data['first_name'], $data['last_name'], $data['bidang_ilmu']);

                        // 3. Buat record User
                        $user = $model::create($data);

                        // 4. Update data Profile yang otomatis terbuat dari method booted()
                        $user->profile->update([
                            'first_name'  => $firstName,
                            'last_name'   => $lastName,
                            'bidang_ilmu' => $bidangIlmu, // <- Masukkan ke database profile
                        ]);

                        return $user;
                    });
                }),
        ];
    }
}