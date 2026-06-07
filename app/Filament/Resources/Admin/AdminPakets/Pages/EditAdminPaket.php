<?php

namespace App\Filament\Resources\Admin\AdminPakets\Pages;

use App\Filament\Resources\Admin\AdminPakets\AdminPaketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminPaket extends EditRecord
{
    protected static string $resource = AdminPaketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
