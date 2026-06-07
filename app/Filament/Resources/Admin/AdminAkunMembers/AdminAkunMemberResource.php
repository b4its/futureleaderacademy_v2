<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers;

use App\Filament\Resources\Admin\AdminAkunMembers\Pages\CreateAdminAkunMember;
use App\Filament\Resources\Admin\AdminAkunMembers\Pages\EditAdminAkunMember;
use App\Filament\Resources\Admin\AdminAkunMembers\Pages\ListAdminAkunMembers;
use App\Filament\Resources\Admin\AdminAkunMembers\Schemas\AdminAkunMemberForm;
use App\Filament\Resources\Admin\AdminAkunMembers\Tables\AdminAkunMembersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminAkunMemberResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'users';
    protected static ?string $slug = 'daftar-member';

    public static function form(Schema $schema): Schema
    {
        return AdminAkunMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminAkunMembersTable::configure($table);
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
        return 'Member';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group'; // bisa diganti icon lain
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminAkunMembers::route('/'),
            // 'create' => CreateAdminAkunMember::route('/create'),
            // 'edit' => EditAdminAkunMember::route('/{record}/edit'),
        ];
    }
}
