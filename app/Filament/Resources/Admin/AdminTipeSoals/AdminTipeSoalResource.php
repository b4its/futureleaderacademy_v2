<?php

namespace App\Filament\Resources\Admin\AdminTipeSoals;

use App\Filament\Resources\Admin\AdminTipeSoals\Pages\CreateAdminTipeSoal;
use App\Filament\Resources\Admin\AdminTipeSoals\Pages\EditAdminTipeSoal;
use App\Filament\Resources\Admin\AdminTipeSoals\Pages\ListAdminTipeSoals;
use App\Filament\Resources\Admin\AdminTipeSoals\Schemas\AdminTipeSoalForm;
use App\Filament\Resources\Admin\AdminTipeSoals\Tables\AdminTipeSoalsTable;
use App\Models\TipeSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminTipeSoalResource extends Resource
{
    protected static ?string $model = TipeSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tipe_soal';
    protected static ?string $slug = 'tipe-soal';

    public static function form(Schema $schema): Schema
    {
        return AdminTipeSoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminTipeSoalsTable::configure($table);
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
        return 'Tipe Soal';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group'; // bisa diganti icon lain
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminTipeSoals::route('/'),
            // 'create' => CreateAdminTipeSoal::route('/create'),
            // 'edit' => EditAdminTipeSoal::route('/{record}/edit'),
        ];
    }
}
