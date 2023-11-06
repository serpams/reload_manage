<?php

namespace App\Filament\Analitics\Resources\ExtratoResource\Pages;

use App\Filament\Analitics\Resources\ExtratoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtratos extends ListRecords
{
    protected static string $resource = ExtratoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
