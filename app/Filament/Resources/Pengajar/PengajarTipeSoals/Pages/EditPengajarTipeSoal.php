<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarTipeSoals\PengajarTipeSoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajarTipeSoal extends EditRecord
{
    protected static string $resource = PengajarTipeSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
