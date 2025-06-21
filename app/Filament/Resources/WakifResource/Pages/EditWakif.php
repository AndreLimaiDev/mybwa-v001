<?php

namespace App\Filament\Resources\WakifResource\Pages;

use App\Filament\Resources\WakifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWakif extends EditRecord
{
    protected static string $resource = WakifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
