<?php

namespace App\Filament\Resources\Admin\AdminSoals;

use App\Filament\Resources\Admin\AdminSoals\Pages\CreateAdminSoal;
use App\Filament\Resources\Admin\AdminSoals\Pages\EditAdminSoal;
use App\Filament\Resources\Admin\AdminSoals\Pages\ListAdminSoals;
use App\Filament\Resources\Admin\AdminSoals\Schemas\AdminSoalForm;
use App\Filament\Resources\Admin\AdminSoals\Schemas\AdminSoalInfolist;
use App\Filament\Resources\Admin\AdminSoals\Tables\AdminSoalsTable;
use App\Models\Soal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminSoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'soal';
    protected static ?string $slug = 'soal';

    public static function form(Schema $schema): Schema
    {
        return AdminSoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdminSoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminSoalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): string
    {
        return 'Pembelajaran';
    }
    public static function getNavigationLabel(): string
    {
        return 'Soal';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-question-mark-circle';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminSoals::route('/'),
            // 'create' => CreateAdminSoal::route('/create'),
            // 'edit' => EditAdminSoal::route('/{record}/edit'),
        ];
    }
}
