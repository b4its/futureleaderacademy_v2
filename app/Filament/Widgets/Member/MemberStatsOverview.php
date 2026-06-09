<?php

namespace App\Filament\Widgets\Member;

use App\Models\HasilTes;
use App\Models\TesPengetahuan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MemberStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        $totalTes = TesPengetahuan::where('status', 1)->count();
        $tesDikerjakan = HasilTes::where('user_id', $userId)->count();
        $rataRataNilai = HasilTes::where('user_id', $userId)->avg('total_nilai');
        $nilaiTertinggi = HasilTes::where('user_id', $userId)->max('total_nilai');
        $nilaiTerendah = HasilTes::where('user_id', $userId)->min('total_nilai');

        return [
            Stat::make('Tes Tersedia', $totalTes)
                ->description('Total tes yang bisa dikerjakan')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary')
                ->chart([4, 5, 6, 5, 7, 6, 8]),

            Stat::make('Tes Dikerjakan', $tesDikerjakan)
                ->description('Jumlah tes yang sudah diselesaikan')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Rata-rata Nilai', $rataRataNilai ? number_format((float) $rataRataNilai, 1) : '0')
                ->description('Nilai rata-rata Anda')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),

            Stat::make('Nilai Tertinggi', $nilaiTertinggi ?? '0')
                ->description('Skor terbaik Anda')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),

            Stat::make('Nilai Terendah', $nilaiTerendah ?? '0')
                ->description('Skor terendah Anda')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
