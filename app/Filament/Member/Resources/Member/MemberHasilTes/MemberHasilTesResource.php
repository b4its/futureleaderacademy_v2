<?php

namespace App\Filament\Member\Resources\Member\MemberHasilTes;

use App\Filament\Member\Resources\Member\MemberHasilTes\Pages\ListMemberHasilTes;
use App\Filament\Member\Resources\Member\MemberHasilTes\Tables\MemberHasilTesTable;
use App\Models\HasilTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MemberHasilTesResource extends Resource
{
    protected static ?string $model = HasilTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $recordTitleAttribute = 'total_nilai';
    protected static ?string $slug = 'hasil-tes-saya';

    public static function table(Table $table): Table
    {
        return MemberHasilTesTable::configure($table);
    }

    public static function getNavigationGroup(): string
    {
        return 'Pembelajaran';
    }

    public static function getNavigationLabel(): string
    {
        return 'Hasil Tes Saya';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMemberHasilTes::route('/'),
        ];
    }
}
