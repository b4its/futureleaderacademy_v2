<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Pages;

use App\Filament\Resources\Pengajar\PengajarPaketTesHasils\PengajarPaketTesHasilResource;
use Filament\Resources\Pages\ListRecords;

class ListPengajarPaketTesHasils extends ListRecords
{
    protected static string $resource = PengajarPaketTesHasilResource::class;
    protected static ?string $title = 'Hasil Paket Tes';
}
