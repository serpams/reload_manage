<?php

namespace App\Filament\Transactions\Widgets;

use App\Models\Expenses;
use App\Models\Transactions;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DespesasWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Stat::make('Despesas', Expenses::sum('valor')),
            // Stat::make('Compras',  Transactions::where('type', 'venda')->sum('valor_convertido')),
            // Stat::make('Vendas',  Transactions::where('type', 'Compra')->sum('valor_convertido')),
        ];
    }
}
