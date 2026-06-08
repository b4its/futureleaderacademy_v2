<?php

namespace App\Filament\Member\Resources\Member\MemberHasilTes\Pages;

use App\Filament\Member\Resources\Member\MemberHasilTes\MemberHasilTesResource;
use Filament\Resources\Pages\ListRecords;

class ListMemberHasilTes extends ListRecords
{
    protected static string $resource = MemberHasilTesResource::class;
    protected static ?string $title = "Hasil Tes Saya";
}
