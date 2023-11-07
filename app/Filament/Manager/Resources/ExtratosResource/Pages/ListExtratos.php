<?php

namespace App\Filament\Manager\Resources\ExtratosResource\Pages;

use App\Filament\Manager\Resources\ExtratosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtratos extends ListRecords
{
    protected static string $resource = ExtratosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
