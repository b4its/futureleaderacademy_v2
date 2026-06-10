<?php

namespace App\Filament\Resources\Pengajar\PengajarSoals;

use App\Filament\Resources\Pengajar\PengajarSoals\Pages\CreatePengajarSoal;
use App\Filament\Resources\Pengajar\PengajarSoals\Pages\EditPengajarSoal;
use App\Filament\Resources\Pengajar\PengajarSoals\Pages\ListPengajarSoals;
use App\Filament\Resources\Pengajar\PengajarSoals\Schemas\PengajarSoalForm;
use App\Filament\Resources\Pengajar\PengajarSoals\Schemas\PengajarSoalInfolist;
use App\Filament\Resources\Pengajar\PengajarSoals\Tables\PengajarSoalsTable;
use App\Models\Soal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarSoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'pertanyaan';
    protected static ?string $slug = 'pengajar-soals';

    public static function form(Schema $schema): Schema
    {
        return PengajarSoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PengajarSoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarSoalsTable::configure($table);
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
        return 'Bank Soal';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-question-mark-circle';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarSoals::route('/'),
            // 'create' => CreatePengajarSoal::route('/create'),
            // 'edit' => EditPengajarSoal::route('/{record}/edit'),
        ];
    }
}
