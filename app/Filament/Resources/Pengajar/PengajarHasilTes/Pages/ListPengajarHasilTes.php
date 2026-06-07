<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes\Pages;

use App\Filament\Resources\Pengajar\PengajarHasilTes\PengajarHasilTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajarHasilTes extends ListRecords
{
    protected static string $resource = PengajarHasilTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
