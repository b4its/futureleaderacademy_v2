<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Pages;

use App\Filament\Resources\Admin\AdminTesPengetahuans\AdminTesPengetahuanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminTesPengetahuan extends EditRecord
{
    protected static string $resource = AdminTesPengetahuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
