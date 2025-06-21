<?php

namespace App\Filament\Resources\WakifResource\Pages;

use App\Filament\Resources\WakifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWakifs extends ListRecords
{
    protected static string $resource = WakifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
