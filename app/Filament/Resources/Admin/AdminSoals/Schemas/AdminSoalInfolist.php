<?php

namespace App\Filament\Resources\Admin\AdminSoals\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminSoalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Soal')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('tipeSoal.title')->label('Tipe Soal')->placeholder('-'),
                        TextEntry::make('kategoriTes.title')->label('Kategori Tes')->placeholder('-'),
                        TextEntry::make('pengajar.name')->label('Pengajar')->placeholder('-'),
                        TextEntry::make('jawaban_benar')->label('Kunci Jawaban')->badge()->color('success'),
                        TextEntry::make('bobot_nilai')->label('Bobot Nilai')->badge()->color('warning'),
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Pertanyaan')
                    ->schema([
                        TextEntry::make('pertanyaan')
                            ->hiddenLabel()
                            ->html()
                            ->placeholder('(Pertanyaan bergambar)')
                            ->columnSpanFull(),
                        ImageEntry::make('visual_pertanyaan')
                            ->label('Gambar Pertanyaan')
                            ->disk('public_folder')
                            ->placeholder('Tidak ada gambar')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pilihan Jawaban')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('jawaban_a')->label('Pilihan A')->html()->placeholder('-'),
                        TextEntry::make('jawaban_b')->label('Pilihan B')->html()->placeholder('-'),
                        TextEntry::make('jawaban_c')->label('Pilihan C')->html()->placeholder('-'),
                        TextEntry::make('jawaban_d')->label('Pilihan D')->html()->placeholder('-'),
                        TextEntry::make('jawaban_e')->label('Pilihan E')->html()->placeholder('-'),
                    ]),
            ]);
    }
}
