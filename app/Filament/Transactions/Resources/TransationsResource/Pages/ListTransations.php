<?php

namespace App\Filament\Transactions\Resources\TransationsResource\Pages;

use App\Filament\Transactions\Resources\TransationsResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
class ListTransations extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = TransationsResource::class;
   // lazy true
    protected static bool $lazy = true;
    
    protected function getHeaderWidgets(): array
    {
        return TransationsResource::getWidgets();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All'),
            'Compras' => ListRecords\Tab::make()->query(fn ($query) => $query->where('type', 'compra')),
            'Vendas' => ListRecords\Tab::make()->query(fn ($query) => $query->where('type', 'venda')),
        ];
    }
}
