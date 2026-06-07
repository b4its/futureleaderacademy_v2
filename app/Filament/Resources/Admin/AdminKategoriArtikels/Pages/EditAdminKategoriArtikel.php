<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels\Pages;

use App\Filament\Resources\Admin\AdminKategoriArtikels\AdminKategoriArtikelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminKategoriArtikel extends EditRecord
{
    protected static string $resource = AdminKategoriArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
