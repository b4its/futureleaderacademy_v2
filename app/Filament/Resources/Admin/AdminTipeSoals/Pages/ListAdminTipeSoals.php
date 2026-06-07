<?php

namespace App\Filament\Resources\Admin\AdminTipeSoals\Pages;

use App\Filament\Resources\Admin\AdminTipeSoals\AdminTipeSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminTipeSoals extends ListRecords
{
    protected static string $resource = AdminTipeSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
