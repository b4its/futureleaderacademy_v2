<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Pages;

use App\Filament\Resources\Admin\AdminAkunPengajars\AdminAkunPengajarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminAkunPengajar extends EditRecord
{
    protected static string $resource = AdminAkunPengajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
