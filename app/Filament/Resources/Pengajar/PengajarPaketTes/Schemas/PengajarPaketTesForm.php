<?php

namespace App\Filament\Resources\Pengajar\PengajarPaketTes\Schemas;

use App\Models\PaketTes;
use App\Models\TipeSoal;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PengajarPaketTesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Paket')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama')
                                ->label('Nama Paket')
                                ->placeholder('Contoh: UTBK STAN')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('kode_paket')
                                ->label('Kode Paket')
                                ->helperText('Kosongkan untuk dibuat otomatis.')
                                ->maxLength(255),
                        ]),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            Select::make('mode_penilaian')
                                ->label('Mode Penilaian')
                                ->options(PaketTes::modeOptions())
                                ->default(PaketTes::MODE_TERPISAH)
                                ->required()
                                ->native(false),

                            TextInput::make('batas_waktu')
                                ->label('Batas Waktu (menit)')
                                ->numeric()
                                ->minValue(1)
                                ->helperText('Total waktu untuk seluruh paket.'),

                            Grid::make(1)->schema([
                                Toggle::make('is_paid')->label('Berbayar')->default(true),
                                Toggle::make('status')->label('Aktif')->default(true),
                            ]),
                        ]),
                    ]),

                Section::make('Sub-Tes yang Digabung')
                    ->description('Pilih tes milik Anda yang akan digabung ke dalam paket ini.')
                    ->schema([
                        Select::make('tesList')
                            ->label('Daftar Sub-Tes')
                            ->relationship(
                                'tesList',
                                'pelajaran',
                                fn (Builder $query) => $query->whereIn(
                                    'tipe_soal_id',
                                    TipeSoal::where('pengajar_id', auth()->id())->select('id')
                                )
                            )
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->minItems(1)
                            ->helperText('Tiap sub-tes tetap dinilai sesuai bobot soalnya sendiri.'),
                    ]),
            ]);
    }
}
