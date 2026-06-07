<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes\Pages;

use App\Filament\Resources\Pengajar\PengajarHasilTes\PengajarHasilTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajarHasilTes extends EditRecord
{
    protected static string $resource = PengajarHasilTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
