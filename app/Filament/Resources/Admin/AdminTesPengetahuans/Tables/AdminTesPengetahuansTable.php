<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Tables;

use App\Models\Soal;
use App\Models\TesPengetahuan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AdminTesPengetahuansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                TesPengetahuan::query()
                    // Pastikan nama tabel 'users' sesuai migrasi
                    ->selectRaw('tes_pengetahuan.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('kode_tes')->label("Kode Tes"),
                TextColumn::make('kategoriTes.title')->label("Jenis Tes"),

                TextColumn::make('pelajaran')->label("Pelajaran"),

                TextColumn::make('total_soal')
                    ->label("Jumlah Soal")
                    ->badge()
                    ->color('gray'),

                TextColumn::make('total_bobot')
                    ->label("Total Bobot")
                    ->badge()
                    ->color('warning'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),

                // Tombol untuk menambahkan soal ke tes ini (mirip pembelajaran/pengajar/create).
                Action::make('tambahSoal')
                    ->label('Tambah Soal')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->modalHeading(fn (TesPengetahuan $record) => 'Tambah Soal - ' . ($record->pelajaran ?? 'Tes'))
                    ->modalDescription('Tambahkan satu atau beberapa soal sekaligus ke tes ini.')
                    ->modalSubmitActionLabel('Simpan Soal')
                    ->modalWidth('5xl')
                    ->schema([
                        Repeater::make('soal')
                            ->label('Daftar Soal')
                            ->addActionLabel('Tambah Pertanyaan')
                            ->defaultItems(1)
                            ->columns(1)
                            ->schema([
                                Textarea::make('pertanyaan')
                                    ->label('Pertanyaan')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),

                                Grid::make(2)->schema([
                                    TextInput::make('jawaban_a')->label('Pilihan A')->required(),
                                    TextInput::make('jawaban_b')->label('Pilihan B')->required(),
                                    TextInput::make('jawaban_c')->label('Pilihan C'),
                                    TextInput::make('jawaban_d')->label('Pilihan D'),
                                    TextInput::make('jawaban_e')->label('Pilihan E'),
                                ]),

                                Grid::make(2)->schema([
                                    Select::make('jawaban_benar')
                                        ->label('Kunci Jawaban')
                                        ->options([
                                            'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E',
                                        ])
                                        ->required(),

                                    TextInput::make('bobot_nilai')
                                        ->label('Bobot Nilai')
                                        ->numeric()
                                        ->minValue(0)
                                        ->default(1)
                                        ->required(),
                                ]),
                            ]),
                    ])
                    ->action(function (array $data, TesPengetahuan $record): void {
                        // Ambil pengajar pemilik tipe soal (jika ada) untuk pencatatan.
                        $pengajarId = $record->tipeSoal?->pengajar_id;

                        foreach ($data['soal'] as $item) {
                            Soal::create([
                                'user_id' => Auth::id(),
                                'pengajar_id' => $pengajarId,
                                'tipe_soal_id' => $record->tipe_soal_id,
                                'kategori_tes_id' => $record->kategori_tes_id,
                                'pertanyaan' => $item['pertanyaan'] ?? null,
                                'jawaban_a' => $item['jawaban_a'] ?? null,
                                'jawaban_b' => $item['jawaban_b'] ?? null,
                                'jawaban_c' => $item['jawaban_c'] ?? null,
                                'jawaban_d' => $item['jawaban_d'] ?? null,
                                'jawaban_e' => $item['jawaban_e'] ?? null,
                                'jawaban_benar' => strtoupper($item['jawaban_benar']),
                                'bobot_nilai' => (int) ($item['bobot_nilai'] ?? 1),
                            ]);
                        }

                        // total_soal & total_bobot otomatis tersinkron via observer pada model Soal.
                        Notification::make()
                            ->title('Berhasil')
                            ->body(count($data['soal']) . ' soal ditambahkan ke tes ini.')
                            ->success()
                            ->send();
                    }),

                EditAction::make()
                    ->form([
                        TextInput::make('batas_waktu')
                            ->label('Batas Waktu')
                            ->maxLength(255)
                            ->placeholder('Contoh: 90 Menit'),
                        
                        Toggle::make('is_paid')
                            ->label('Tes Berbayar'),
                            
                        Toggle::make('status')
                            ->label('Aktifkan Soal'),
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
