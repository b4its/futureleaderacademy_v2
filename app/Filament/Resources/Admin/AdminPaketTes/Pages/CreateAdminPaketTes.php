<?php

namespace App\Filament\Resources\Admin\AdminPaketTes\Pages;

use App\Filament\Resources\Admin\AdminPaketTes\AdminPaketTesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAdminPaketTes extends CreateRecord
{
    protected static string $resource = AdminPaketTesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['kode_paket'])) {
            $data['kode_paket'] = 'PKT-' . strtoupper(Str::random(6));
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Sinkron total soal & bobot dari sub-tes yang baru ditautkan.
        $this->record->rekalkulasi();
    }
}
