<?php

namespace App\Filament\Transactions\Resources\SitesResource\Pages;

use App\Filament\Transactions\Resources\SitesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSites extends ListRecords
{
    protected static string $resource = SitesResource::class;
   
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
