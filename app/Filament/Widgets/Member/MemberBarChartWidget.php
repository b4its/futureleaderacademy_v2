<?php

namespace App\Filament\Widgets\Member;

use App\Models\HasilTes;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MemberBarChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return 'Tes Dikerjakan per Bulan';
    }

    protected function getData(): array
    {
        $userId = Auth::id();
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $data[] = HasilTes::where('user_id', $userId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tes Dikerjakan',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(249, 115, 22, 0.6)',
                        'rgba(234, 88, 12, 0.6)',
                        'rgba(251, 146, 60, 0.6)',
                        'rgba(253, 186, 116, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(245, 158, 11, 0.6)',
                    ],
                    'borderColor' => 'rgba(249, 115, 22, 1)',
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
