<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarTipeSoals\PengajarTipeSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajarTipeSoals extends ListRecords
{
    protected static string $resource = PengajarTipeSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
