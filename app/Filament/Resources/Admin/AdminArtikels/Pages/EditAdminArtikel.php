<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Pages;

use App\Filament\Resources\Admin\AdminArtikels\AdminArtikelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminArtikel extends EditRecord
{
    protected static string $resource = AdminArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
