<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes\Pages;

use App\Filament\Resources\Admin\AdminKategoriTes\AdminKategoriTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminKategoriTes extends ListRecords
{
    protected static string $resource = AdminKategoriTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
