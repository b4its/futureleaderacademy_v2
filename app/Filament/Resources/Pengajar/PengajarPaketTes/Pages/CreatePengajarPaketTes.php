<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTes\Pages;

use App\Filament\Resources\Pengajar\PengajarPaketTes\PengajarPaketTesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePengajarPaketTes extends CreateRecord
{
    protected static string $resource = PengajarPaketTesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pengajar_id'] = auth()->id();

        if (empty($data['kode_paket'])) {
            $data['kode_paket'] = 'PKT-' . strtoupper(Str::random(6));
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->rekalkulasi();
    }
}
