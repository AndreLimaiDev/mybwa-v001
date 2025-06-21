<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SumberResource\Pages;
use App\Filament\Resources\SumberResource\RelationManagers;
use App\Models\Sumber;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SumberResource extends Resource
{
    protected static ?string $model = Sumber::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Sumber Data';

    protected static ?string $navigationGroup = 'Setting';

    protected static ?string $navigationGroupIcon = 'Setting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_sumber')
                    ->label('Nama Sumber')
                    ->required(),
                Select::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_sumber')
                    ->label('Nama Sumber'),
                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSumbers::route('/'),
            // 'create' => Pages\CreateSumber::route('/create'),
            // 'edit' => Pages\EditSumber::route('/{record}/edit'),
        ];
    }
}
