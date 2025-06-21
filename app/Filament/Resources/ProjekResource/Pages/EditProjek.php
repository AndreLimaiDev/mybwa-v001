<?php

namespace App\Filament\Resources\ProjekResource\Pages;

use App\Filament\Resources\ProjekResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjek extends EditRecord
{
    protected static string $resource = ProjekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
