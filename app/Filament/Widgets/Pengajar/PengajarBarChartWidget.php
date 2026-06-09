<?php

namespace App\Filament\Widgets\Pengajar;

use App\Models\Soal;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PengajarBarChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return 'Soal Dibuat per Bulan';
    }

    protected function getData(): array
    {
        $pengajarId = Auth::id();
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $data[] = Soal::where('pengajar_id', $pengajarId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Soal Dibuat',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.6)',
                        'rgba(59, 130, 246, 0.6)',
                        'rgba(245, 158, 11, 0.6)',
                        'rgba(139, 92, 246, 0.6)',
                        'rgba(239, 68, 68, 0.6)',
                        'rgba(20, 184, 166, 0.6)',
                    ],
                    'borderColor' => 'rgba(16, 185, 129, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
