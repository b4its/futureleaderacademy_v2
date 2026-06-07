<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals;

use App\Filament\Resources\Pengajar\PengajarSoals\Pages\CreatePengajarSoal;
use App\Filament\Resources\Pengajar\PengajarSoals\Pages\EditPengajarSoal;
use App\Filament\Resources\Pengajar\PengajarSoals\Pages\ListPengajarSoals;
use App\Filament\Resources\Pengajar\PengajarSoals\Schemas\PengajarSoalForm;
use App\Filament\Resources\Pengajar\PengajarSoals\Tables\PengajarSoalsTable;
use App\Models\PengajarSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajarSoalResource extends Resource
{
    protected static ?string $model = PengajarSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'soal';

    public static function form(Schema $schema): Schema
    {
        return PengajarSoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarSoalsTable::configure($table);
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
            'index' => ListPengajarSoals::route('/'),
            'create' => CreatePengajarSoal::route('/create'),
            'edit' => EditPengajarSoal::route('/{record}/edit'),
        ];
    }
}
