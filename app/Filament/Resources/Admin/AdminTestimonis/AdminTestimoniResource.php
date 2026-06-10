<?php

namespace App\Filament\Resources\Admin\AdminTestimonis;

use App\Filament\Resources\Admin\AdminTestimonis\Pages\CreateAdminTestimoni;
use App\Filament\Resources\Admin\AdminTestimonis\Pages\EditAdminTestimoni;
use App\Filament\Resources\Admin\AdminTestimonis\Pages\ListAdminTestimonis;
use App\Filament\Resources\Admin\AdminTestimonis\Schemas\AdminTestimoniForm;
use App\Filament\Resources\Admin\AdminTestimonis\Schemas\AdminTestimoniInfolist;
use App\Filament\Resources\Admin\AdminTestimonis\Tables\AdminTestimonisTable;
use App\Models\Testimoni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminTestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'testimoni';
    protected static ?string $slug = 'testimoni';

    public static function form(Schema $schema): Schema
    {
        return AdminTestimoniForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdminTestimoniInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminTestimonisTable::configure($table);
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
        return 'Testimoni';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chat-bubble-left-right';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminTestimonis::route('/'),
            // 'create' => CreateAdminTestimoni::route('/create'),
            // 'edit' => EditAdminTestimoni::route('/{record}/edit'),
        ];
    }
}
