<?php

namespace App\Filament\App\Resources\TesteResource\Pages;

use App\Filament\App\Resources\TesteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestes extends ListRecords
{
    protected static string $resource = TesteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
