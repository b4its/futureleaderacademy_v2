<?php

namespace App\Filament\Resources\Admin\AdminHasilTes\Pages;

use App\Filament\Resources\Admin\AdminHasilTes\AdminHasilTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminHasilTes extends ListRecords
{
    protected static string $resource = AdminHasilTesResource::class;
    protected static ?string $title = "Daftar Hasil Tes";

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
