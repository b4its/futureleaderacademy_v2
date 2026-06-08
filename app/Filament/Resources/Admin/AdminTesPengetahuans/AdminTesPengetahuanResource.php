<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans;

use App\Filament\Resources\Admin\AdminTesPengetahuans\Pages\CreateAdminTesPengetahuan;
use App\Filament\Resources\Admin\AdminTesPengetahuans\Pages\EditAdminTesPengetahuan;
use App\Filament\Resources\Admin\AdminTesPengetahuans\Pages\ListAdminTesPengetahuans;
use App\Filament\Resources\Admin\AdminTesPengetahuans\Schemas\AdminTesPengetahuanForm;
use App\Filament\Resources\Admin\AdminTesPengetahuans\Tables\AdminTesPengetahuansTable;
use App\Models\AdminTesPengetahuan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminTesPengetahuanResource extends Resource
{
    protected static ?string $model = AdminTesPengetahuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tes_pengetahuan';
    protected static ?string $slug = 'tes-pengetahuan';

    public static function form(Schema $schema): Schema
    {
        return AdminTesPengetahuanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminTesPengetahuansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): string
    {
        return 'Ujian';
    }
    public static function getNavigationLabel(): string
    {
        return 'Tes Pengetahuan';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-academic-cap';
    }
    

    public static function getPages(): array
    {
        return [
            'index' => ListAdminTesPengetahuans::route('/'),
            // 'create' => CreateAdminTesPengetahuan::route('/create'),
            // 'edit' => EditAdminTesPengetahuan::route('/{record}/edit'),
        ];
    }
}
