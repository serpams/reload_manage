<?php

namespace App\Filament\Manager\Resources\ExtratosResource\Pages;

use App\Filament\Manager\Resources\ExtratosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtratos extends EditRecord
{
    protected static string $resource = ExtratosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
