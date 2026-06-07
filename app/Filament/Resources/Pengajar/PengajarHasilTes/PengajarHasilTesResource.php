<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes;

use App\Filament\Resources\Pengajar\PengajarHasilTes\Pages\CreatePengajarHasilTes;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Pages\EditPengajarHasilTes;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Pages\ListPengajarHasilTes;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Schemas\PengajarHasilTesForm;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Tables\PengajarHasilTesTable;
use App\Models\PengajarHasilTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajarHasilTesResource extends Resource
{
    protected static ?string $model = PengajarHasilTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'hasil_tes';

    public static function form(Schema $schema): Schema
    {
        return PengajarHasilTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarHasilTesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarHasilTes::route('/'),
            'create' => CreatePengajarHasilTes::route('/create'),
            'edit' => EditPengajarHasilTes::route('/{record}/edit'),
        ];
    }
}
