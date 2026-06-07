<?php

namespace App\Filament\Resources\Admin\AdminSoals;

use App\Filament\Resources\Admin\AdminSoals\Pages\CreateAdminSoal;
use App\Filament\Resources\Admin\AdminSoals\Pages\EditAdminSoal;
use App\Filament\Resources\Admin\AdminSoals\Pages\ListAdminSoals;
use App\Filament\Resources\Admin\AdminSoals\Schemas\AdminSoalForm;
use App\Filament\Resources\Admin\AdminSoals\Tables\AdminSoalsTable;
use App\Models\AdminSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminSoalResource extends Resource
{
    protected static ?string $model = AdminSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'soal';

    public static function form(Schema $schema): Schema
    {
        return AdminSoalForm::configure($schema);
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

    public static function getPages(): array
    {
        return [
            'index' => ListAdminSoals::route('/'),
            'create' => CreateAdminSoal::route('/create'),
            'edit' => EditAdminSoal::route('/{record}/edit'),
        ];
    }
}
