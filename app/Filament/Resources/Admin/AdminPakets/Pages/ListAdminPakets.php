<?php

namespace App\Filament\Resources\Admin\AdminPakets\Pages;

use App\Filament\Resources\Admin\AdminPakets\AdminPaketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminPakets extends ListRecords
{
    protected static string $resource = AdminPaketResource::class;
    protected static ?string $title = "Daftar Paket";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Paket')
            ->modalHeading('Tambahkan Paket'),
        ];
    }
}
