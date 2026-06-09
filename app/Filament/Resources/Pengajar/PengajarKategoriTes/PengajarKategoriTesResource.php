<?php

namespace App\Filament\Resources\Pengajar\PengajarKategoriTes;

use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\CreatePengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\EditPengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Pages\ListPengajarKategoriTes;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Schemas\PengajarKategoriTesForm;
use App\Filament\Resources\Pengajar\PengajarKategoriTes\Tables\PengajarKategoriTesTable;
use App\Models\KategoriTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajarKategoriTesResource extends Resource
{
    protected static ?string $model = KategoriTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $slug = 'pengajar-kategori-tes';

    public static function form(Schema $schema): Schema
    {
        return PengajarKategoriTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarKategoriTesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationGroup(): string
    {
        return 'Pembelajaran';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kategori Tes';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-folder';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarKategoriTes::route('/'),
            // 'create' => CreatePengajarKategoriTes::route('/create'),
            // 'edit' => EditPengajarKategoriTes::route('/{record}/edit'),
        ];
    }
}
