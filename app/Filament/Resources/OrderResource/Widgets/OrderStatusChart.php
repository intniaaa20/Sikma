<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Order per Status';
    protected static ?string $pollingInterval = '30s'; // Optional: auto-refresh

    protected function getData(): array
    {
        $statuses = ['done', 'pending', 'sending'];
        $counts = [];
        foreach ($statuses as $status) {
            $counts[] = \App\Models\Order::where('status', $status)->count();
        }
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Order',
                    'data' => $counts,
                    'backgroundColor' => ['#22c55e', '#facc15', '#38bdf8'],
                ],
            ],
            'labels' => ['Done', 'Pending', 'Sending'],
        ];
    }

    protected function getType(): string
    {
        // Default chart type: bar
        return 'bar';
    }
}
