<?php

namespace App\Filament\Manager\Resources\ComprovantesResource\Pages;

use App\Filament\Manager\Resources\ComprovantesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComprovantes extends EditRecord
{
    protected static string $resource = ComprovantesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
