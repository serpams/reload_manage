<?php

namespace App\Filament\Analitics\Resources\ExtratoResource\Pages;

use App\Filament\Analitics\Resources\ExtratoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtrato extends EditRecord
{
    protected static string $resource = ExtratoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
