<?php

namespace App\Filament\Resources\Admin\AdminArtikels;

use App\Filament\Resources\Admin\AdminArtikels\Pages\CreateAdminArtikel;
use App\Filament\Resources\Admin\AdminArtikels\Pages\EditAdminArtikel;
use App\Filament\Resources\Admin\AdminArtikels\Pages\ListAdminArtikels;
use App\Filament\Resources\Admin\AdminArtikels\Schemas\AdminArtikelForm;
use App\Filament\Resources\Admin\AdminArtikels\Tables\AdminArtikelsTable;
use App\Models\Artikel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'artikel';
    protected static ?string $slug = 'artikel';

    public static function form(Schema $schema): Schema
    {
        return AdminArtikelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminArtikelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): string
    {
        return 'Artikel';
    }
    public static function getNavigationLabel(): string
    {
        return 'Artikel';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group'; // bisa diganti icon lain
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminArtikels::route('/'),
            // 'create' => CreateAdminArtikel::route('/create'),
            // 'edit' => EditAdminArtikel::route('/{record}/edit'),
        ];
    }
}
