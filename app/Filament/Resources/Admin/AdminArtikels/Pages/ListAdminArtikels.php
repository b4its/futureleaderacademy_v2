<?php

namespace App\Filament\Resources\Admin\AdminArtikels\Pages;

use App\Filament\Resources\Admin\AdminArtikels\AdminArtikelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminArtikels extends ListRecords
{
    protected static string $resource = AdminArtikelResource::class;
    protected static ?string $title = "Daftar Artikel";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Artikel')
            ->modalHeading('Tambahkan Artikel'),
        ];
    }
}
