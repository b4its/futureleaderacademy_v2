<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes\Pages;

use App\Filament\Resources\Admin\AdminKategoriTes\AdminKategoriTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminKategoriTes extends EditRecord
{
    protected static string $resource = AdminKategoriTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
