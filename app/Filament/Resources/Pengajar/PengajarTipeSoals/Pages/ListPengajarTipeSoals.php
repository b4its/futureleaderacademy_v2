<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages;

use App\Filament\Resources\Pengajar\PengajarTipeSoals\PengajarTipeSoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListPengajarTipeSoals extends ListRecords
{
    protected static string $resource = PengajarTipeSoalResource::class;
    protected static ?string $title = 'Tipe Soal Saya';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Tipe Soal')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = Auth::id();
                    return $data;
                }),
        ];
    }
}
