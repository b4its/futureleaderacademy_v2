<?php

namespace App\Filament\Resources\Admin\AdminAkunPengajars;

use App\Filament\Resources\Admin\AdminAkunPengajars\Pages\CreateAdminAkunPengajar;
use App\Filament\Resources\Admin\AdminAkunPengajars\Pages\EditAdminAkunPengajar;
use App\Filament\Resources\Admin\AdminAkunPengajars\Pages\ListAdminAkunPengajars;
use App\Filament\Resources\Admin\AdminAkunPengajars\Schemas\AdminAkunPengajarForm;
use App\Filament\Resources\Admin\AdminAkunPengajars\Tables\AdminAkunPengajarsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminAkunPengajarResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'users';
    protected static ?string $slug = 'daftar-pengajar';

    public static function form(Schema $schema): Schema
    {
        return AdminAkunPengajarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminAkunPengajarsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): string
    {
        return 'Akun';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pengajar';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group'; // bisa diganti icon lain
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminAkunPengajars::route('/'),
            // 'create' => CreateAdminAkunPengajar::route('/create'),
            // 'edit' => EditAdminAkunPengajar::route('/{record}/edit'),
        ];
    }
}
