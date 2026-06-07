<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarSoals\PengajarSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajarSoals extends ListRecords
{
    protected static string $resource = PengajarSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
