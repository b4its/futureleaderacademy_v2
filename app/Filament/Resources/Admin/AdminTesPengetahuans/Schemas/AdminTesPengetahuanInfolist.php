<?php

namespace App\Filament\Resources\Admin\AdminTesPengetahuans\Schemas;

use App\Models\Soal;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminTesPengetahuanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tes')
                    ->description('Detail data tes pengetahuan.')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('kode_tes')
                            ->label('Kode Tes')
                            ->badge()
                            ->color('primary')
                            ->copyable(),

                        TextEntry::make('pelajaran')
                            ->label('Pelajaran'),

                        TextEntry::make('kategoriTes.title')
                            ->label('Kategori Tes')
                            ->placeholder('-'),

                        TextEntry::make('tipeSoal.title')
                            ->label('Tipe Soal')
                            ->placeholder('-'),

                        TextEntry::make('total_soal')
                            ->label('Jumlah Soal')
                            ->badge()
                            ->color('gray')
                            ->suffix(' soal'),

                        TextEntry::make('total_bobot')
                            ->label('Total Bobot (Skor Maksimal)')
                            ->badge()
                            ->color('warning'),

                        TextEntry::make('batas_waktu')
                            ->label('Batas Waktu')
                            ->suffix(' menit')
                            ->placeholder('-'),

                        TextEntry::make('is_paid')
                            ->label('Tipe Akses')
                            ->badge()
                            ->state(fn ($record) => $record->is_paid ? 'Berbayar' : 'Gratis')
                            ->color(fn ($record) => $record->is_paid ? 'success' : 'gray'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Aktif' : 'Draft')
                            ->color(fn ($record) => $record->status ? 'success' : 'danger'),

                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y, H:i'),

                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Statistik Pengerjaan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('jumlah_pengerjaan')
                            ->label('Total Dikerjakan')
                            ->state(fn ($record) => $record->hasilTes()->count() . ' kali'),

                        TextEntry::make('rata_rata_nilai')
                            ->label('Rata-rata Nilai')
                            ->state(fn ($record) => number_format((float) $record->hasilTes()->avg('total_nilai'), 2)),

                        TextEntry::make('nilai_tertinggi')
                            ->label('Nilai Tertinggi')
                            ->state(fn ($record) => number_format((float) $record->hasilTes()->max('total_nilai'), 2)),
                    ]),

                Section::make('Daftar Soal Terkait')
                    ->description('Seluruh soal pada kombinasi kategori & tipe tes ini.')
                    ->schema([
                        RepeatableEntry::make('soalTerkait')
                            ->hiddenLabel()
                            ->state(fn ($record) => Soal::where('kategori_tes_id', $record->kategori_tes_id)
                                ->where('tipe_soal_id', $record->tipe_soal_id)
                                ->get())
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('pertanyaan')
                                        ->label('Pertanyaan')
                                        ->html()
                                        ->placeholder('(Soal bergambar)')
                                        ->columnSpan(2),

                                    TextEntry::make('jawaban_benar')
                                        ->label('Kunci')
                                        ->badge()
                                        ->color('success'),

                                    TextEntry::make('bobot_nilai')
                                        ->label('Bobot')
                                        ->badge()
                                        ->color('warning'),
                                ]),
                            ])
                            ->placeholder('Belum ada soal.'),
                    ]),
            ]);
    }
}
