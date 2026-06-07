<?php

namespace App\Filament\Resources\Admin\AdminTipeSoals\Pages;

use App\Filament\Resources\Admin\AdminTipeSoals\AdminTipeSoalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminTipeSoal extends EditRecord
{
    protected static string $resource = AdminTipeSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
