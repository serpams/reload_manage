<?php

namespace App\Filament\Transactions\Widgets;

use App\Filament\Transactions\Resources\SitesResource\Pages\ListSites;
// use App\Filament\Transactions\Resources\TransationsResource\Pages\ListTransations;
use Filament\Widgets\Concerns\InteractsWithPageTable;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SitesWidgets extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListSites::class;
    }
    protected function getStats(): array
    {
        return [
            // Stat::make('Open orders',$this->getPageTableQuery()->count()),
        ];
    }
}

