<?php

namespace App\Filament\Resources\Admin\AdminAkunMembers\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminAkunMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email')->copyable(),
                        TextEntry::make('role')->label('Role')->badge()->color('primary'),
                        TextEntry::make('created_at')->label('Terdaftar')->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Profil')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('profile.gambar')
                            ->label('Foto Profil')
                            ->disk('public_folder')
                            ->placeholder('Tidak ada foto')
                            ->columnSpanFull(),

                        TextEntry::make('profile.first_name')->label('Nama Depan')->placeholder('-'),
                        TextEntry::make('profile.last_name')->label('Nama Belakang')->placeholder('-'),
                        TextEntry::make('profile.bidang_ilmu')->label('Bidang Ilmu')->placeholder('-'),
                        TextEntry::make('profile.kelas.name')->label('Kelas / Paket')->placeholder('Belum ada kelas'),
                    ]),

                Section::make('Riwayat Tes')
                    ->schema([
                        TextEntry::make('jumlah_tes')
                            ->label('Total Tes Dikerjakan')
                            ->badge()
                            ->color('info')
                            ->state(fn ($record) => $record->profile ? \App\Models\HasilTes::where('user_id', $record->id)->count() . ' kali' : '0 kali'),
                        TextEntry::make('rata_rata_nilai')
                            ->label('Rata-rata Nilai')
                            ->state(fn ($record) => number_format((float) \App\Models\HasilTes::where('user_id', $record->id)->avg('total_nilai'), 2)),
                    ])
                    ->columns(2),
            ]);
    }
}
