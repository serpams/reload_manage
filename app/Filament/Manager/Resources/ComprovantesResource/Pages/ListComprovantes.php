<?php

namespace App\Filament\Manager\Resources\ComprovantesResource\Pages;

use App\Filament\Manager\Resources\ComprovantesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComprovantes extends ListRecords
{
    protected static string $resource = ComprovantesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
