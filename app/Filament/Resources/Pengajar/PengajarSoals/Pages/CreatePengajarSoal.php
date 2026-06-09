<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarSoals\PengajarSoalResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajarSoal extends CreateRecord
{
    protected static string $resource = PengajarSoalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['pengajar_id'] = auth()->id();
        return $data;
    }
}
