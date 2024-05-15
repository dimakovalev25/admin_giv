<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThing extends ListRecords
{
    protected static string $resource = ThingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
