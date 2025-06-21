<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Branch;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
 
class RegisterBranch extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register branch';
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Branch Name')
                    ->required(),
                // ...
            ]);
    }
 
    protected function handleRegistration(array $data): Branch
    {
        $branch = Branch::create($data);
 
        $branch->anggotas()->attach(\Illuminate\Support\Facades\Auth::user());
 
        return $branch;
    }
}