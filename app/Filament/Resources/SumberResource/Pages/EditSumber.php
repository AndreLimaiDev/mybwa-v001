<?php

namespace App\Filament\Resources\SumberResource\Pages;

use App\Filament\Resources\SumberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSumber extends EditRecord
{
    protected static string $resource = SumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
