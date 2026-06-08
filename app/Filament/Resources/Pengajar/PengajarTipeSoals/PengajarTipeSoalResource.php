<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals;

use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\CreatePengajarTipeSoal;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\EditPengajarTipeSoal;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\ListPengajarTipeSoals;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Schemas\PengajarTipeSoalForm;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Tables\PengajarTipeSoalsTable;
use App\Models\PengajarTipeSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajarTipeSoalResource extends Resource
{
    protected static ?string $model = PengajarTipeSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tipe_soal';

    public static function form(Schema $schema): Schema
    {
        return PengajarTipeSoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarTipeSoalsTable::configure($table);
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
            'index' => ListPengajarTipeSoals::route('/'),
            // 'create' => CreatePengajarTipeSoal::route('/create'),
            // 'edit' => EditPengajarTipeSoal::route('/{record}/edit'),
        ];
    }
}
