<?php

namespace App\Filament\Resources\Admin\AdminTestimonis\Pages;

use App\Filament\Resources\Admin\AdminTestimonis\AdminTestimoniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminTestimonis extends ListRecords
{
    protected static string $resource = AdminTestimoniResource::class;
    protected static ?string $title = "Daftar Testimoni";

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label("Tambahkan Testimoni")
                ->modalHeading("Tambahkan Testimoni"),
        ];
    }
}
