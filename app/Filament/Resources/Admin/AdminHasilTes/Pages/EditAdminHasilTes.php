<?php

namespace App\Filament\Resources\Admin\AdminHasilTes\Pages;

use App\Filament\Resources\Admin\AdminHasilTes\AdminHasilTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminHasilTes extends EditRecord
{
    protected static string $resource = AdminHasilTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
