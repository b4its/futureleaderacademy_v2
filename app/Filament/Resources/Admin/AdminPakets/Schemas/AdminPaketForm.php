<?php

namespace App\Filament\Resources\Admin\AdminPakets\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class AdminPaketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            TextInput::make('name')
                ->label('Nama Paket')
                ->maxLength(255), // Sesuai varchar(255)
                
            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->maxLength(255) // Sesuai varchar(255)
                ->columnSpanFull(),

            // Menggunakan Repeater karena kolom 'benefit' bertipe JSON
            Repeater::make('benefit')
                ->label('Keuntungan atau Benefit')
                ->schema([
                    TextInput::make('item')
                        ->label('Benefit')
                        ->required(),
                ])
                ->createItemButtonLabel('Tambahkan Benefit')
                ->columnSpanFull(),

            TextInput::make('harga')
                ->label('Harga Paket')
                ->prefix('Rp') 
                ->mask(RawJs::make('$money($input, \',\', \'.\', 0)')) // Format angka Indonesia
                ->stripCharacters('.') // Buang titik sebelum masuk ke database
                ->numeric()
                ->default(0)
                ->required(),
            ]);
    }
}
