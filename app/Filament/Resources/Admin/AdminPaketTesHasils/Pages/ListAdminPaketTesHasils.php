<?php

namespace App\Filament\Resources\Admin\AdminPaketTesHasils\Pages;

use App\Filament\Resources\Admin\AdminPaketTesHasils\AdminPaketTesHasilResource;
use Filament\Resources\Pages\ListRecords;

class ListAdminPaketTesHasils extends ListRecords
{
    protected static string $resource = AdminPaketTesHasilResource::class;
    protected static ?string $title = 'Hasil Paket Tes';
}
