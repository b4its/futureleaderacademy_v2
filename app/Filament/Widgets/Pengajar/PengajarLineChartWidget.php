<?php

namespace App\Filament\Widgets\Pengajar;

use App\Models\HasilTes;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PengajarLineChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return 'Tren Nilai Rata-rata Member per Bulan';
    }

    protected function getData(): array
    {
        $avgValues = [];
        $totalDikerjakan = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');

            $avg = HasilTes::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->avg('total_nilai');

            $avgValues[] = $avg ? round((float) $avg, 1) : 0;

            $totalDikerjakan[] = HasilTes::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata Nilai',
                    'data' => $avgValues,
                    'borderColor' => 'rgba(16, 185, 129, 1)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Jumlah Dikerjakan',
                    'data' => $totalDikerjakan,
                    'borderColor' => 'rgba(245, 158, 11, 1)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
