<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Pages;

use App\Filament\Resources\Admin\AdminAkunMembers\AdminAkunMemberResource;
use App\Models\Profile;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListAdminAkunMembers extends ListRecords
{
    protected static string $resource = AdminAkunMemberResource::class;
    protected static ?string $title = "Daftar Member";

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

                        // 1. Ambil data profil dari form dan hapus dari array $data
                        // agar tidak error "column not found" saat create User
                        $firstName = $data['first_name'] ?? null;
                        $lastName = $data['last_name'] ?? null;
                        unset($data['first_name'], $data['last_name']);

                        // 2. Buat record User-nya dulu.
                        // Proses ini akan memicu method booted() -> static::created di model User
                        // yang otomatis membuat Profile kosong beserta user_id-nya.
                        $user = $model::create($data);

                        // 3. Update data Profile yang otomatis terbuat tadi
                        $user->profile->update([
                            'first_name' => $firstName,
                            'last_name'  => $lastName,
                        ]);

                        // 4. Wajib return instance model utama (User)
                        return $user;
                    });
                }),
            
        ];
    }
}
