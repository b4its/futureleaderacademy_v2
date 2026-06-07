<?php

namespace App\Filament\Resources\Admin\AdminSoals\Pages;

use App\Filament\Resources\Admin\AdminSoals\AdminSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminSoals extends ListRecords
{
    protected static string $resource = AdminSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
