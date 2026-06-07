<?php

namespace App\Filament\Resources\Admin\AdminKategoriTes;

use App\Filament\Resources\Admin\AdminKategoriTes\Pages\CreateAdminKategoriTes;
use App\Filament\Resources\Admin\AdminKategoriTes\Pages\EditAdminKategoriTes;
use App\Filament\Resources\Admin\AdminKategoriTes\Pages\ListAdminKategoriTes;
use App\Filament\Resources\Admin\AdminKategoriTes\Schemas\AdminKategoriTesForm;
use App\Filament\Resources\Admin\AdminKategoriTes\Tables\AdminKategoriTesTable;
use App\Models\AdminKategoriTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminKategoriTesResource extends Resource
{
    protected static ?string $model = AdminKategoriTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kategori_tes';

    public static function form(Schema $schema): Schema
    {
        return AdminKategoriTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminKategoriTesTable::configure($table);
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
            'index' => ListAdminKategoriTes::route('/'),
            'create' => CreateAdminKategoriTes::route('/create'),
            'edit' => EditAdminKategoriTes::route('/{record}/edit'),
        ];
    }
}
