<?php

namespace App\Filament\Transactions\Widgets;

use App\Filament\Transactions\Resources\TransationsResource\Pages\ListTransations;
use App\Models\Expenses;
use App\Models\Sites;
use App\Models\Transactions;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WidgetTransactions extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListTransations::class;
    }
    protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        $ret = [ Stat::make('Despesas', 'R$ '.Expenses::sum('valor'))];
        $sites = Sites::all();
        $pos = 1;
        foreach($sites as $site){
            $saldo =  Transactions::where('sites_id',$site->id)->where('type','compra')->sum('valor') - Transactions::where('sites_id',$site->id)->where('type','venda')->sum('valor') ;
            $ret[$pos] = Stat::make('Saldo Site', '$ '.$saldo)->description('Site: '.$site->name)
            ->descriptionIcon('heroicon-o-arrows-up-down');
            $pos = $pos + 1;
        }

        return $ret;
        //  [
        //     // Stat::make('Open orders',$this->getPageTableQuery()->count()),
        //     Stat::make('Despesas', 'R$ '.Expenses::sum('valor')),
        //     Stat::make('Compras', '$ '.Transactions::where('type', 'compra')->sum('valor')),
        //     Stat::make('Vendas',  '$ '.Transactions::where('type', 'venda')->sum('valor')),
        // ];
    }
}
