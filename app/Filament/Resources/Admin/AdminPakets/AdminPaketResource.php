<?php

namespace App\Filament\Resources\Admin\AdminPakets;

use App\Filament\Resources\Admin\AdminPakets\Pages\CreateAdminPaket;
use App\Filament\Resources\Admin\AdminPakets\Pages\EditAdminPaket;
use App\Filament\Resources\Admin\AdminPakets\Pages\ListAdminPakets;
use App\Filament\Resources\Admin\AdminPakets\Schemas\AdminPaketForm;
use App\Filament\Resources\Admin\AdminPakets\Tables\AdminPaketsTable;
use App\Models\Kelas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminPaketResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kelas';
    protected static ?string $slug = 'paket';

    public static function form(Schema $schema): Schema
    {
        return AdminPaketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminPaketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): string
    {
        return 'Program';
    }

    public static function getNavigationLabel(): string
    {
        return 'Paket / Kelas';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-credit-card';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminPakets::route('/'),
            // 'create' => CreateAdminPaket::route('/create'),
            // 'edit' => EditAdminPaket::route('/{record}/edit'),
        ];
    }
}
