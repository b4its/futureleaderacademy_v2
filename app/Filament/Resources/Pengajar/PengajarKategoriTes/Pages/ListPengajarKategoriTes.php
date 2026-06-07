<?php

namespace App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages;

use App\Filament\Resources\Pengajar\PengajarKategoriTes\PengajarKategoriTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajarKategoriTes extends ListRecords
{
    protected static string $resource = PengajarKategoriTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
