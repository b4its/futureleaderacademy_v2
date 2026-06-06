<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Pages;

use App\Filament\Resources\Admin\AdminAkunMembers\AdminAkunMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminAkunMembers extends ListRecords
{
    protected static string $resource = AdminAkunMemberResource::class;
    protected static ?string $title = "Daftar Member";

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
