<?php

namespace App\Filament\Resources\Admin\AdminTestimonis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AdminTestimoniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            Select::make('provinsi')
                ->label('Asal Provinsi')
                ->options(function () {
                    // Mengambil seluruh data provinsi dari API Emsifa
                    $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
                    
                    return $response->successful() 
                        ? collect($response->json())->pluck('name', 'id') 
                        : [];
                })
                ->searchable()
                ->preload()
                ->required()
                ->live() // Wajib ada agar saat diubah, field kota otomatis update
                ->afterStateUpdated(fn (Set $set) => $set('kota_asal', null)), // Reset kota jika provinsi diubah

            Select::make('kota_asal')
                ->label('Asal Kota')
                ->options(function (Get $get) {
                    // Ambil ID Provinsi yang sedang dipilih
                    $provinsiId = $get('provinsi');
                    
                    // Jika belum ada provinsi yang dipilih, kosongkan pilihan kota
                    if (! $provinsiId) {
                        return [];
                    }
                    
                    // Mengambil kota secara live berdasarkan ID Provinsi
                    $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinsiId}.json");
                    
                    return $response->successful() 
                        // Kita pluck 'name', 'name' agar yang disimpan ke database adalah 
                        // nama kotanya (misal: "SAMARINDA"), bukan ID angkanya.
                        ? collect($response->json())->pluck('name', 'name') 
                        : [];
                })
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('nama_pengguna')
                ->label('Nama Pengguna')
                ->maxLength(255), // Sesuai varchar(255)

            Textarea::make('pesan')
                ->label('Pesan')
                ->columnSpanFull()
                ->maxLength(255), // Sesuai varchar(255)
                
            Textarea::make('pencapaian')
                ->label('Pencapaian')
                ->maxLength(255) // Sesuai varchar(255)
                ->columnSpanFull(),
            ]);
    }
}
