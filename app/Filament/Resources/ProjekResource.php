<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjekResource\Pages;
use App\Filament\Resources\ProjekResource\RelationManagers;
use App\Models\Projek;
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

class ProjekResource extends Resource
{
    protected static ?string $model = Projek::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationLabel = 'Projek';

    protected static ?string $navigationGroup = 'CRM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('program_id')
                    ->label('Program')
                    ->relationship('program', 'nama_program')
                    ->required(),
                TextInput::make('nama_projek')
                    ->label('Nama Projek')
                    ->required(),
                TextInput::make('kode_unik')
                    ->label('Kode Unik')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Funding' => 'Funding',
                        'Full Funded' => 'Full Funded',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('program.nama_program')
                    ->label('Program')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_projek')
                    ->label('Nama Projek')
                    ->description(fn(Projek $record): string => $record->kode_unik)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->icon(fn(string $state): string => match ($state) {
                        'Funding' => 'heroicon-o-arrow-path',
                        'Full Funded' => 'heroicon-o-check',
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Funding' => 'warning',
                        'Full Funded' => 'success',
                    })
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
            'index' => Pages\ListProjeks::route('/'),
            'create' => Pages\CreateProjek::route('/create'),
            'edit' => Pages\EditProjek::route('/{record}/edit'),
        ];
    }
}
