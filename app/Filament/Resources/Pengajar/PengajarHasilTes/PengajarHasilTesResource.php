<?php

namespace App\Filament\Resources\Pengajar\PengajarHasilTes;

use App\Filament\Resources\Pengajar\PengajarHasilTes\Pages\ListPengajarHasilTes;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Schemas\PengajarHasilTesForm;
use App\Filament\Resources\Pengajar\PengajarHasilTes\Tables\PengajarHasilTesTable;
use App\Models\HasilTes;
use App\Models\TesPengetahuan;
use App\Models\TipeSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarHasilTesResource extends Resource
{
    protected static ?string $model = HasilTes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $slug = 'pengajar-hasil-tes';

    public static function form(Schema $schema): Schema
    {
        return PengajarHasilTesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarHasilTesTable::configure($table);
    }

    /**
     * Hanya tampilkan hasil tes dari tes milik pengajar ini.
     */
    public static function getEloquentQuery(): Builder
    {
        $pengajarId = auth()->id();

        // Ambil ID tes yang terkait dengan tipe soal milik pengajar
        $tipeSoalIds = TipeSoal::where('pengajar_id', $pengajarId)->pluck('id');
        $tesIds = TesPengetahuan::whereIn('tipe_soal_id', $tipeSoalIds)->pluck('id');

        return parent::getEloquentQuery()
            ->whereIn('tes_pengetahuan_id', $tesIds);
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
        return 'Hasil Tes';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-clipboard-document-check';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajarHasilTes::route('/'),
        ];
    }
}
