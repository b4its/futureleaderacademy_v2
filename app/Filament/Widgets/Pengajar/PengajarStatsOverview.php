<?php

namespace App\Filament\Widgets\Pengajar;

use App\Models\HasilTes;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\TipeSoal;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PengajarStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pengajarId = Auth::id();

        $totalSoalDibuat = Soal::where('pengajar_id', $pengajarId)->count();
        $totalTipeSoal = TipeSoal::where('pengajar_id', $pengajarId)->count();
        $totalTes = TesPengetahuan::count();
        $totalHasilTes = HasilTes::count();
        $rataRataNilai = HasilTes::avg('total_nilai');

        return [
            Stat::make('Soal Dibuat', $totalSoalDibuat)
                ->description('Soal yang Anda buat')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('primary')
                ->chart([3, 5, 7, 4, 6, 8, 5]),

            Stat::make('Tipe Soal', $totalTipeSoal)
                ->description('Tipe soal yang Anda kelola')
                ->descriptionIcon('heroicon-o-tag')
                ->color('info'),

            Stat::make('Total Tes', $totalTes)
                ->description('Tes pengetahuan tersedia')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('warning'),

            Stat::make('Member Mengerjakan', $totalHasilTes)
                ->description('Total pengerjaan tes')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Rata-rata Nilai', $rataRataNilai ? number_format((float) $rataRataNilai, 1) : '0')
                ->description('Nilai rata-rata semua member')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('danger'),
        ];
    }
}
