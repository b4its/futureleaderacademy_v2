<?php

namespace App\Filament\Widgets\Admin;

use App\Models\HasilTes;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class AdminBarChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return 'Tes Dikerjakan per Bulan';
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $data[] = HasilTes::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tes Dikerjakan',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 205, 86, 0.6)',
                    ],
                    'borderColor' => 'rgba(255, 159, 64, 1)',
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
