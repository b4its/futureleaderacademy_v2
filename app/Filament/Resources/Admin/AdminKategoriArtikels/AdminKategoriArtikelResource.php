<?php

namespace App\Filament\Resources\Admin\AdminKategoriArtikels;

use App\Filament\Resources\Admin\AdminKategoriArtikels\Pages\CreateAdminKategoriArtikel;
use App\Filament\Resources\Admin\AdminKategoriArtikels\Pages\EditAdminKategoriArtikel;
use App\Filament\Resources\Admin\AdminKategoriArtikels\Pages\ListAdminKategoriArtikels;
use App\Filament\Resources\Admin\AdminKategoriArtikels\Schemas\AdminKategoriArtikelForm;
use App\Filament\Resources\Admin\AdminKategoriArtikels\Tables\AdminKategoriArtikelsTable;
use App\Models\KategoriArtikel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminKategoriArtikelResource extends Resource
{
    protected static ?string $model = KategoriArtikel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kategori_artikel';
    protected static ?string $slug = 'kategori-artikel';

    public static function form(Schema $schema): Schema
    {
        return AdminKategoriArtikelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminKategoriArtikelsTable::configure($table);
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
        return 'Kategori Artikel';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-tag';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminKategoriArtikels::route('/'),
            // 'create' => CreateAdminKategoriArtikel::route('/create'),
            // 'edit' => EditAdminKategoriArtikel::route('/{record}/edit'),
        ];
    }
}
