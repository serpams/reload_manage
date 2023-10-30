<?php

namespace App\Filament\Transactions\Resources\SitesResource\Pages;

use App\Filament\Transactions\Resources\SitesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSites extends EditRecord
{
    protected static string $resource = SitesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
