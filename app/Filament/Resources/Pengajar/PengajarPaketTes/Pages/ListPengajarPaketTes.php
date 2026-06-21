<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTes\Pages;

use App\Filament\Resources\Pengajar\PengajarPaketTes\PengajarPaketTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajarPaketTes extends ListRecords
{
    protected static string $resource = PengajarPaketTesResource::class;
    protected static ?string $title = 'Daftar Paket Tes';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Paket Tes'),
        ];
    }
}
