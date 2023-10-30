<?php

namespace App\Filament\Transactions\Resources\TransationsResource\Pages;

use App\Filament\Transactions\Resources\TransationsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransations extends CreateRecord
{
    protected static string $resource = TransationsResource::class;
    protected function beforeValidate(): void
    {
        // Runs before the form fields are validated when the form is submitted.
    }
}
