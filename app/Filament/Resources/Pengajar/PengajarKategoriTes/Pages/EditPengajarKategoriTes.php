<?php

namespace App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages;

use App\Filament\Resources\Pengajar\PengajarKategoriTes\PengajarKategoriTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajarKategoriTes extends EditRecord
{
    protected static string $resource = PengajarKategoriTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
