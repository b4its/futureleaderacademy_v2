<?php

namespace App\Filament\Resources\Admin\AdminPaketTesHasils;

use App\Filament\Resources\Admin\AdminPaketTesHasils\Pages\ListAdminPaketTesHasils;
use App\Filament\Resources\Admin\AdminPaketTesHasils\Schemas\AdminPaketTesHasilInfolist;
use App\Filament\Resources\Admin\AdminPaketTesHasils\Tables\AdminPaketTesHasilsTable;
use App\Models\PaketTesHasil;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdminPaketTesHasilResource extends Resource
{
    protected static ?string $model = PaketTesHasil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $slug = 'paket-hasil-tes';

    public static function infolist(Schema $schema): Schema
    {
        return AdminPaketTesHasilInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminPaketTesHasilsTable::configure($table);
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
        return 'Hasil Paket Tes';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-list';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdminPaketTesHasils::route('/'),
        ];
    }
}
