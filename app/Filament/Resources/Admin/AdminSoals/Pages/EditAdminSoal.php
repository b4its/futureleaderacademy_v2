<?php

namespace App\Filament\Resources\Admin\AdminSoals\Pages;

use App\Filament\Resources\Admin\AdminSoals\AdminSoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminSoal extends EditRecord
{
    protected static string $resource = AdminSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
