<?php

namespace App\Filament\Resources\Admin\AdminHasilTes;

use App\Filament\Resources\Admin\AdminHasilTes\Pages\CreateAdminHasilTes;
use App\Filament\Resources\Admin\AdminHasilTes\Pages\EditAdminHasilTes;
use App\Filament\Resources\Admin\AdminHasilTes\Pages\ListAdminHasilTes;
use App\Filament\Resources\Admin\AdminHasilTes\Schemas\AdminHasilTesForm;
use App\Filament\Resources\Admin\AdminHasilTes\Tables\AdminHasilTesTable;
use App\Models\AdminHasilTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminHasilTesResource extends Resource
{
    protected static ?string $model = AdminHasilTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'hasil_tes';

    public static function form(Schema $schema): Schema
    {
        return AdminHasilTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminHasilTesTable::configure($table);
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
            'index' => ListAdminHasilTes::route('/'),
            'create' => CreateAdminHasilTes::route('/create'),
            'edit' => EditAdminHasilTes::route('/{record}/edit'),
        ];
    }
}
