<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes\Pages;

use App\Filament\Resources\Admin\AdminKategoriTes\AdminKategoriTesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminKategoriTes extends ListRecords
{
    protected static string $resource = AdminKategoriTesResource::class;
    protected static ?string $title = "Daftar Kategori Tes";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Kategori Tes')
                ->modalHeading('Tambahkan Kategori Tes'),
        ];
    }
}
