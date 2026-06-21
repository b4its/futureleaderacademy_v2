<?php

namespace App\Filament\Resources\Admin\AdminPaketTes;

use App\Filament\Resources\Admin\AdminPaketTes\Pages\CreateAdminPaketTes;
use App\Filament\Resources\Admin\AdminPaketTes\Pages\EditAdminPaketTes;
use App\Filament\Resources\Admin\AdminPaketTes\Pages\ListAdminPaketTes;
use App\Filament\Resources\Admin\AdminPaketTes\Schemas\AdminPaketTesForm;
use App\Filament\Resources\Admin\AdminPaketTes\Schemas\AdminPaketTesInfolist;
use App\Filament\Resources\Admin\AdminPaketTes\Tables\AdminPaketTesTable;
use App\Models\PaketTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminPaketTesResource extends Resource
{
    protected static ?string $model = PaketTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $slug = 'paket-tes';

    public static function form(Schema $schema): Schema
    {
        return AdminPaketTesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdminPaketTesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminPaketTesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationGroup(): string
    {
        return 'Ujian';
    }

    public static function getNavigationLabel(): string
    {
        return 'Paket Tes';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-rectangle-group';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminPaketTes::route('/'),
            'create' => CreateAdminPaketTes::route('/create'),
            'edit' => EditAdminPaketTes::route('/{record}/edit'),
        ];
    }
}
