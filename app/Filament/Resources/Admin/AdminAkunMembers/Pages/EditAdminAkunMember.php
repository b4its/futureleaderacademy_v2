<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Pages;

use App\Filament\Resources\Admin\AdminAkunMembers\AdminAkunMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminAkunMember extends EditRecord
{
    protected static string $resource = AdminAkunMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Mutasi data sebelum fill ke form.
     * Memastikan data profile (first_name, last_name, kelas_id) ikut ter-load ke form.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $profile = $this->record->profile;

        $data['profile'] = [
            'first_name' => $profile?->first_name,
            'last_name' => $profile?->last_name,
            'kelas_id' => $profile?->kelas_id,
        ];

        return $data;
    }

    /**
     * Mutasi data sebelum save.
     * Memisahkan data profile dari data user agar tidak error kolom tidak ditemukan.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $profileData = $data['profile'] ?? [];
        unset($data['profile']);

        // Update profile secara terpisah
        $profile = $this->record->profile;
        if ($profile) {
            $profile->update([
                'first_name' => $profileData['first_name'] ?? null,
                'last_name' => $profileData['last_name'] ?? null,
                'kelas_id' => $profileData['kelas_id'] ?? null,
            ]);
        }

        return $data;
    }
}
