<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Pages;

use App\Filament\Resources\Admin\AdminTesPengetahuans\AdminTesPengetahuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminTesPengetahuans extends ListRecords
{
    protected static string $resource = AdminTesPengetahuanResource::class;
    protected static ?string $title = "Daftar Tes";

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
