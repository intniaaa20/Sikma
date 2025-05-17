<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Tampilkan widget statistik order di atas tabel
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\OrderResource\Widgets\OrderStatusChart::class,
        ];
    }
}
