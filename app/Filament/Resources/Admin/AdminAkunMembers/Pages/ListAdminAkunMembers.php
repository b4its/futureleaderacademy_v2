<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Pages;

use App\Filament\Resources\Admin\AdminAkunMembers\AdminAkunMemberResource;
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
            CreateAction::make()
                ->label('Tambahkan Member')
                ->modalHeading('Tambahkan Member')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['role'] = 'member';
                    return $data;
                })
                ->using(function (array $data, string $model): Model {
                    return DB::transaction(function () use ($data, $model) {

                        // 1. Ambil data profil dari form dan hapus dari array $data
                        $profileData = $data['profile'] ?? [];
                        unset($data['profile']);

                        // 2. Buat record User (akan otomatis membuat Profile kosong via booted())
                        $user = $model::create($data);

                        // 3. Update Profile yang sudah otomatis terbuat
                        if ($user->profile && !empty($profileData)) {
                            $user->profile->update([
                                'first_name' => $profileData['first_name'] ?? null,
                                'last_name' => $profileData['last_name'] ?? null,
                                'kelas_id' => $profileData['kelas_id'] ?? null,
                            ]);
                        }

                        return $user;
                    });
                }),
        ];
    }
}
