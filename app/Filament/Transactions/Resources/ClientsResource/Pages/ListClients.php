<?php

namespace App\Filament\Transactions\Resources\ClientsResource\Pages;

use App\Filament\Transactions\Resources\ClientsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
