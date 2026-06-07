<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels\Pages;

use App\Filament\Resources\Admin\AdminKategoriArtikels\AdminKategoriArtikelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminKategoriArtikels extends ListRecords
{
    protected static string $resource = AdminKategoriArtikelResource::class;
    protected static ?string $title = "Daftar Kategori Artikel";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Kategori Artikel')
                ->modalHeading('Tambahkan Kategori Artikel')


        ];
    }
}
