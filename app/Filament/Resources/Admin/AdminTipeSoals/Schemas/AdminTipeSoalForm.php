<?php

namespace App\Filament\Resources\Admin\AdminTipeSoals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminTipeSoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('pengajar_id')
                    ->label('Pengajar')
                    ->relationship(
                        'pengajar', 
                        'name', 
                        fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('role', 'pengajar')
                    ) 
                    ->getOptionLabelFromRecordUsing(fn (\Illuminate\Database\Eloquent\Model $record) => "{$record->name} - {$record->profile->bidang_ilmu}")
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Tipe Soal')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
