<?php

namespace App\Filament\Transactions\Resources\DespesasResource\Pages;

use App\Filament\Transactions\Resources\DespesasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDespesas extends ListRecords
{
    protected static string $resource = DespesasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
