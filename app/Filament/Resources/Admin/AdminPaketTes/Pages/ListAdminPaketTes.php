<?php

namespace App\Filament\Resources\Admin\AdminPaketTes\Pages;

use App\Filament\Resources\Admin\AdminPaketTes\AdminPaketTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminPaketTes extends ListRecords
{
    protected static string $resource = AdminPaketTesResource::class;
    protected static ?string $title = 'Daftar Paket Tes';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Paket Tes'),
        ];
    }
}
