<?php

namespace App\Filament\Widgets\Member;

use App\Models\HasilTes;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class MemberRiwayatTesTable extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Riwayat Tes Terbaru';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                HasilTes::query()
                    ->where('user_id', Auth::id())
                    ->with(['tesPengetahuan'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('tesPengetahuan.pelajaran')
                    ->label('Pelajaran')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tesPengetahuan.kode_tes')
                    ->label('Kode Tes'),

                Tables\Columns\TextColumn::make('jumlah_benar')
                    ->label('Benar')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('jumlah_salah')
                    ->label('Salah')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_nilai')
                    ->label('Nilai')
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        (int) $state >= 80 => 'success',
                        (int) $state >= 60 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\IconColumn::make('status')
                    ->label('Selesai')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([5, 10]);
    }
}
