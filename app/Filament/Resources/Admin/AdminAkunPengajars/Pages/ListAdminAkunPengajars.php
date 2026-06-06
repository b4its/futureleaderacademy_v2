<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars\Pages;

use App\Filament\Resources\Admin\AdminAkunPengajars\AdminAkunPengajarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminAkunPengajars extends ListRecords
{
    protected static string $resource = AdminAkunPengajarResource::class;
    protected static ?string $title = "Daftar Pengajar";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambahkan Pengajar')
            ->modalHeading('Tambahkan Pengajar')
            ->mutateFormDataUsing(function (array $data): array {
                    $data['role'] = "pengajar";
                    return $data;
                }),
        ];
    }
}
