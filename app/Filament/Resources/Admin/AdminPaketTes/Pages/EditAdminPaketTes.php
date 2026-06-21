<?php

namespace App\Filament\Resources\Admin\AdminPaketTes\Pages;

use App\Filament\Resources\Admin\AdminPaketTes\AdminPaketTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminPaketTes extends EditRecord
{
    protected static string $resource = AdminPaketTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Sinkron total soal & bobot setelah perubahan daftar sub-tes.
        $this->record->rekalkulasi();
    }
}
