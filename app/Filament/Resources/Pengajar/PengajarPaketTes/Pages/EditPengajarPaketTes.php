<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTes\Pages;

use App\Filament\Resources\Pengajar\PengajarPaketTes\PengajarPaketTesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajarPaketTes extends EditRecord
{
    protected static string $resource = PengajarPaketTesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->record->rekalkulasi();
    }
}
