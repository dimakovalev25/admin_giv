<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateThing extends CreateRecord
{
    protected static string $resource = ThingResource::class;
}
