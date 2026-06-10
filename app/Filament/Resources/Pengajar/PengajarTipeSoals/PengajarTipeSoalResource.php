<?php

namespace App\Filament\Resources\Pengajar\PengajarTipeSoals;

use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\CreatePengajarTipeSoal;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\EditPengajarTipeSoal;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Pages\ListPengajarTipeSoals;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Schemas\PengajarTipeSoalForm;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Schemas\PengajarTipeSoalInfolist;
use App\Filament\Resources\Pengajar\PengajarTipeSoals\Tables\PengajarTipeSoalsTable;
use App\Models\TipeSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarTipeSoalResource extends Resource
{
    protected static ?string $model = TipeSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $slug = 'pengajar-tipe-soals';

    public static function form(Schema $schema): Schema
    {
        return PengajarTipeSoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PengajarTipeSoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarTipeSoalsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('pengajar_id', auth()->id());
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
        return 'Tipe Soal';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-list-bullet';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarTipeSoals::route('/'),
            // 'create' => CreatePengajarTipeSoal::route('/create'),
            // 'edit' => EditPengajarTipeSoal::route('/{record}/edit'),
        ];
    }
}
