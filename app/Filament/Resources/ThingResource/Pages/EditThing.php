<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThing extends EditRecord
{
    protected static string $resource = ThingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
