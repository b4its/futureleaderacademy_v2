<?php

namespace App\Filament\Member\Widgets\Member;

use App\Models\HasilTes;
use App\Models\TesPengetahuan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TesPengetahuanStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();
        
        // Total tes tersedia
        $totalTes = TesPengetahuan::where('status', 1)->count();
        
        // Total tes yang sudah dikerjakan
        $tesDikerjakan = HasilTes::where('user_id', $userId)->distinct('tes_pengetahuan_id')->count();
        
        // Rata-rata nilai
        $rataRataNilai = HasilTes::where('user_id', $userId)->avg('total_nilai');
        
        // Tes terbaru yang dikerjakan
        $tesTerbaru = HasilTes::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        return [
            Stat::make('Tes Tersedia', $totalTes)
                ->description('Total tes yang bisa dikerjakan')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),
                
            Stat::make('Tes Dikerjakan', $tesDikerjakan . ' / ' . $totalTes)
                ->description('Progress pengerjaan tes')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Rata-rata Nilai', $rataRataNilai ? number_format($rataRataNilai, 2) : '0')
                ->description('Nilai rata-rata dari semua tes')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),
        ];
    }
}
