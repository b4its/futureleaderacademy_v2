<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTes;

use App\Filament\Resources\Pengajar\PengajarPaketTes\Pages\CreatePengajarPaketTes;
use App\Filament\Resources\Pengajar\PengajarPaketTes\Pages\EditPengajarPaketTes;
use App\Filament\Resources\Pengajar\PengajarPaketTes\Pages\ListPengajarPaketTes;
use App\Filament\Resources\Pengajar\PengajarPaketTes\Schemas\PengajarPaketTesForm;
use App\Filament\Resources\Pengajar\PengajarPaketTes\Schemas\PengajarPaketTesInfolist;
use App\Filament\Resources\Pengajar\PengajarPaketTes\Tables\PengajarPaketTesTable;
use App\Models\PaketTes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarPaketTesResource extends Resource
{
    protected static ?string $model = PaketTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $slug = 'pengajar-paket-tes';

    public static function form(Schema $schema): Schema
    {
        return PengajarPaketTesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PengajarPaketTesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarPaketTesTable::configure($table);
    }

    /**
     * Hanya tampilkan paket milik pengajar yang login.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('pengajar_id', auth()->id());
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
        return 'Paket Tes';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-rectangle-group';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarPaketTes::route('/'),
            'create' => CreatePengajarPaketTes::route('/create'),
            'edit' => EditPengajarPaketTes::route('/{record}/edit'),
        ];
    }
}
