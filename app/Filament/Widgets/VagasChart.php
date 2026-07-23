<?php

namespace App\Filament\Widgets;

use App\Models\Vaga;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VagasChart extends ChartWidget
{
    protected static ?string $heading = 'Vagas Criadas';

    protected function getData(): array
    {
        $data = Vaga::forUser()
            ->select(DB::raw('count(id) as count'), DB::raw('DATE(created_at) as date'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Vagas',
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
