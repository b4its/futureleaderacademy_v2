<?php

namespace App\Filament\Resources\Admin\AdminTestimonis\Pages;

use App\Filament\Resources\Admin\AdminTestimonis\AdminTestimoniResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminTestimoni extends EditRecord
{
    protected static string $resource = AdminTestimoniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
