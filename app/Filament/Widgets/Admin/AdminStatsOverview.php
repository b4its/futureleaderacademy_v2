<?php

namespace App\Filament\Widgets\Admin;

use App\Models\Artikel;
use App\Models\HasilTes;
use App\Models\Soal;
use App\Models\TesPengetahuan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalMembers = User::where('role', 'member')->count();
        $totalPengajar = User::where('role', 'pengajar')->count();
        $totalTes = TesPengetahuan::count();
        $totalSoal = Soal::count();
        $totalArtikel = Artikel::count();
        $totalHasilTes = HasilTes::count();

        return [
            Stat::make('Total Member', $totalMembers)
                ->description('Jumlah member terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('Total Pengajar', $totalPengajar)
                ->description('Jumlah pengajar aktif')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('success')
                ->chart([3, 5, 2, 7, 4, 6, 5]),

            Stat::make('Total Tes', $totalTes)
                ->description('Tes pengetahuan tersedia')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('warning')
                ->chart([2, 4, 6, 3, 5, 7, 4]),

            Stat::make('Total Soal', $totalSoal)
                ->description('Bank soal tersedia')
                ->descriptionIcon('heroicon-o-question-mark-circle')
                ->color('info'),

            Stat::make('Total Artikel', $totalArtikel)
                ->description('Artikel dipublikasikan')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Tes Dikerjakan', $totalHasilTes)
                ->description('Total tes yang sudah dikerjakan')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('danger'),
        ];
    }
}
