<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarSoals\PengajarSoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajarSoal extends EditRecord
{
    protected static string $resource = PengajarSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
