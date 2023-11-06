<?php

namespace App\Filament\Analitics\Resources\CuponsResource\Pages;

use App\Filament\Analitics\Resources\CuponsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCupons extends EditRecord
{
    protected static string $resource = CuponsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
