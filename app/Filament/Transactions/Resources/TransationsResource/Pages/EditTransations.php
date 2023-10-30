<?php

namespace App\Filament\Transactions\Resources\TransationsResource\Pages;

use App\Filament\Transactions\Resources\TransationsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransations extends EditRecord
{
    protected static string $resource = TransationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
