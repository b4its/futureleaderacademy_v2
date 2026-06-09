<?php

namespace App\Filament\Widgets\Member;

use App\Models\HasilTes;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MemberLineChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return 'Perkembangan Nilai Anda';
    }

    protected function getData(): array
    {
        $userId = Auth::id();
        $avgValues = [];
        $maxValues = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');

            $avg = HasilTes::where('user_id', $userId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->avg('total_nilai');

            $max = HasilTes::where('user_id', $userId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->max('total_nilai');

            $avgValues[] = $avg ? round((float) $avg, 1) : 0;
            $maxValues[] = $max ? (float) $max : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata Nilai',
                    'data' => $avgValues,
                    'borderColor' => 'rgba(249, 115, 22, 1)',
                    'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Nilai Tertinggi',
                    'data' => $maxValues,
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
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
