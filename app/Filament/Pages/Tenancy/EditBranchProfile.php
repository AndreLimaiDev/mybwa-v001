<?php

namespace App\Filament\Pages\Tenancy;
 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
 
class EditBranchProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Team Profile';
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                TextInput::make('name')
                    ->label('Nama Branch')
                    ->required()
            ]);
    }
}