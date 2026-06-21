<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTesHasils;

use App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Pages\ListPengajarPaketTesHasils;
use App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Schemas\PengajarPaketTesHasilInfolist;
use App\Filament\Resources\Pengajar\PengajarPaketTesHasils\Tables\PengajarPaketTesHasilsTable;
use App\Models\PaketTes;
use App\Models\PaketTesHasil;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarPaketTesHasilResource extends Resource
{
    protected static ?string $model = PaketTesHasil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $slug = 'pengajar-paket-hasil-tes';

    public static function infolist(Schema $schema): Schema
    {
        return PengajarPaketTesHasilInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajarPaketTesHasilsTable::configure($table);
    }

    /**
     * Hanya hasil dari paket milik pengajar yang login.
     */
    public static function getEloquentQuery(): Builder
    {
        $paketIds = PaketTes::where('pengajar_id', auth()->id())->pluck('id');

        return parent::getEloquentQuery()->whereIn('paket_tes_id', $paketIds);
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
            'index' => ListPengajarPaketTesHasils::route('/'),
        ];
    }
}
