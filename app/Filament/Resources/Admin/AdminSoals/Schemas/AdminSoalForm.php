<?php

namespace App\Filament\Resources\Admin\AdminSoals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminSoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: INFORMASI UTAMA SOAL
                Section::make('Informasi Utama Soal')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('pengajar_id')
                                ->label('Pengajar')
                                ->relationship('pengajar', 'name', fn ($query) => $query->where('role', 'pengajar'))
                                ->searchable()
                                ->preload(),

                            Select::make('tipe_soal_id')
                                ->label('Tipe Soal')
                                ->relationship('tipeSoal', 'title') 
                                ->searchable()
                                ->preload(),
                        ]),
                        
                        Grid::make(2)->schema([
                            Select::make('kategori_tes_id')
                                ->label('Kategori Tes')
                                ->relationship('kategoriTes', 'title') 
                                ->searchable()
                                ->preload(),
                            Select::make('jawaban_benar')
                                ->label('Kunci Jawaban Benar')
                                ->options([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'C' => 'C',
                                    'D' => 'D',
                                    'E' => 'E',
                                ])
                                ->required(),
                        ]),

                        \Filament\Forms\Components\TextInput::make('bobot_nilai')
                            ->label('Bobot Nilai')
                            ->helperText('Skor jika soal dijawab benar. Total nilai tes = akumulasi seluruh bobot soal (disarankan total 100).')
                            ->numeric()
                            ->minValue(0)
                            ->default(1)
                            ->required(),
                    ]),

                // SECTION 2: PERTANYAAN
                Section::make('Butir Pertanyaan')
                    ->schema([
                        ToggleButtons::make('mode_pertanyaan')
                            ->label('Format Pertanyaan')
                            ->options([
                                'text' => 'Teks Saja',
                                'gambar' => 'Gambar Saja',
                                'keduanya' => 'Teks & Gambar',
                            ])
                            ->default('text')
                            ->inline()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Kosongkan form secara realtime saat user klik pindah mode
                                if ($state === 'text') {
                                    $set('visual_pertanyaan', null);
                                } elseif ($state === 'gambar') {
                                    $set('pertanyaan', null);
                                }
                            })
                            ->dehydrated(false) 
                            ->afterStateHydrated(function ($component, ?Model $record) {
                                if (!$record) return;
                                if ($record->pertanyaan && $record->visual_pertanyaan) {
                                    $component->state('keduanya');
                                } elseif ($record->visual_pertanyaan) {
                                    $component->state('gambar');
                                } else {
                                    $component->state('text');
                                }
                            }),

                        RichEditor::make('pertanyaan')
                            ->label('Teks Pertanyaan')
                            ->disableToolbarButtons([
                                'attachFiles', 
                            ])
                            ->required(fn (Get $get) => in_array($get('mode_pertanyaan'), ['text', 'keduanya']))
                            ->visible(fn (Get $get) => in_array($get('mode_pertanyaan'), ['text', 'keduanya']))
                            ->dehydrated(true) // Memaksa field dikirim ke DB walau sedang disembunyikan
                            ->dehydrateStateUsing(fn (Get $get, $state) => in_array($get('mode_pertanyaan'), ['text', 'keduanya']) ? $state : null),
                            
                        self::getCustomFileUpload('visual_pertanyaan', 'pertanyaan')
                            ->required(fn (Get $get) => in_array($get('mode_pertanyaan'), ['gambar', 'keduanya']))
                            ->visible(fn (Get $get) => in_array($get('mode_pertanyaan'), ['gambar', 'keduanya']))
                            ->dehydrated(true) // Memaksa field dikirim ke DB walau sedang disembunyikan
                            ->dehydrateStateUsing(fn (Get $get, $state) => in_array($get('mode_pertanyaan'), ['gambar', 'keduanya']) ? $state : null),
                    ]),

                // SECTION 3: PILIHAN JAWABAN (A sampai E)
                Section::make('Pilihan Jawaban')
                    ->description('Pilih format jawaban untuk masing-masing opsi, lalu isi kontennya.')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            self::getAnswerSection('A'),
                            self::getAnswerSection('B'),
                        ]),
                        Grid::make(2)->schema([
                            self::getAnswerSection('C'),
                            self::getAnswerSection('D'),
                        ]),
                        Grid::make(2)->schema([
                            self::getAnswerSection('E'),
                        ]),
                    ]),
            ]);
    }

    /**
     * Helper function untuk meng-generate form Pilihan Jawaban
     */
    private static function getAnswerSection(string $letter): Section
    {
        $lower = strtolower($letter);
        $modeField = "mode_jawaban_{$lower}";
        $textField = "jawaban_{$lower}";
        $imageField = "visual_jawaban_{$lower}";

        return Section::make("Pilihan {$letter}")->schema([
            ToggleButtons::make($modeField)
                ->label("Format Pilihan {$letter}")
                ->options([
                    'text' => 'Teks',
                    'gambar' => 'Gambar',
                    'keduanya' => 'Teks & Gambar',
                ])
                ->default('text')
                ->inline()
                ->live()
                ->afterStateUpdated(function ($state, Set $set) use ($textField, $imageField) {
                    if ($state === 'text') {
                        $set($imageField, null);
                    } elseif ($state === 'gambar') {
                        $set($textField, null);
                    }
                })
                ->dehydrated(false)
                ->afterStateHydrated(function ($component, ?Model $record) use ($textField, $imageField) {
                    if (!$record) return;
                    if ($record->{$textField} && $record->{$imageField}) {
                        $component->state('keduanya');
                    } elseif ($record->{$imageField}) {
                        $component->state('gambar');
                    } else {
                        $component->state('text');
                    }
                }),

            RichEditor::make($textField)
                ->label("Teks {$letter}")
                ->disableToolbarButtons([
                    'attachFiles', 
                ])
                ->visible(fn (Get $get) => in_array($get($modeField), ['text', 'keduanya']))
                ->dehydrated(true)
                ->dehydrateStateUsing(fn (Get $get, $state) => in_array($get($modeField), ['text', 'keduanya']) ? $state : null),

            self::getCustomFileUpload($imageField, "jawab_{$lower}")
                ->visible(fn (Get $get) => in_array($get($modeField), ['gambar', 'keduanya']))
                ->dehydrated(true)
                ->dehydrateStateUsing(fn (Get $get, $state) => in_array($get($modeField), ['gambar', 'keduanya']) ? $state : null),
        ]);
    }

    /**
     * Helper function reusable untuk FileUpload
     */
    private static function getCustomFileUpload(string $columnName, string $prefixName): FileUpload
    {
        return FileUpload::make($columnName)
            ->label('Gambar Pendukung (' . strtoupper($prefixName) . ')')
            ->disk('public_folder')
            ->directory(function (?Model $record) use ($columnName) {
                $soalId = $record?->id ?? 'temp';
                return "media/soal/{$soalId}/{$columnName}";
            })
            ->getUploadedFileNameForStorageUsing(function ($file, ?Model $record) use ($prefixName) {
                $ext = $file->getClientOriginalExtension();
                $datetime = now()->format('Ymd_His');
                $id = $record?->id ?? 'new';
                return "{$prefixName}_{$datetime}_{$id}.{$ext}";
            })
            ->previewable(false) 
            ->extraAttributes(['data-on-error' => 'this.style.display="none"']) 
            ->visibility('public')
            ->preserveFilenames(false)
            ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public_folder')->delete($file));
    }
}