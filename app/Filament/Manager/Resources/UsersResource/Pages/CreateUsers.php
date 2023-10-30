<?php

namespace App\Filament\Manager\Resources\UsersResource\Pages;

use App\Filament\Manager\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;
}
