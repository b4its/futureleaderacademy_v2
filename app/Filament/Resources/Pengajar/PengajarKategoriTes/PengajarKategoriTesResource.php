<?php

namespace App\Filament\Resources\Pengajar\PengajarKategoriTes;

use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\CreatePengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\EditPengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\ListPengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Schemas\PengajarKategoriTesForm;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Tables\PengajarKategoriTesTable;
use App\Models\PengajarKategoriTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajarKategoriTesResource extends Resource
{
    protected static ?string $model = PengajarKategoriTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kategori_tes';

    public static function form(Schema $schema): Schema
    {
        return PengajarKategoriTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarKategoriTesTable::configure($table);
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
            'index' => ListPengajarKategoriTes::route('/'),
            'create' => CreatePengajarKategoriTes::route('/create'),
            'edit' => EditPengajarKategoriTes::route('/{record}/edit'),
        ];
    }
}
