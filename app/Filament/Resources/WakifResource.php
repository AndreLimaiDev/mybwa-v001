<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Wakif;
use App\Models\Branch;
use App\Models\Sumber;
use App\Models\Karyawan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use App\Services\BranchFilterService;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WakifResource\Pages;

class WakifResource extends Resource
{
    protected static ?string $model = Wakif::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Data Wakif';

    protected static ?string $navigationGroup = 'CRM';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Section::make('Personal Info')
                ->columns([
                    'sm' => 1,
                    'xl' => 3,
                ])
                ->schema([
                    Forms\Components\TextInput::make('nama_wakif')
                        ->required(),
                    Forms\Components\TextInput::make('hp')
                        ->required(),
                    Forms\Components\DatePicker::make('tgl_dapat')
                        ->label('Tanggal Dapat')
                        ->required(),
                    Forms\Components\Select::make('wa_status')
                        ->label('Status WA')
                        ->options([
                            'Aktif' => 'Aktif',
                            'Nonaktif' => 'Nonaktif',
                        ]),
                ]),
            Section::make('Detail')
                ->columns([
                    'sm' => 1,
                    'xl' => 3,
                ])
                ->schema([
                    Forms\Components\Select::make('sumber_id')
                        ->label('Sumber')
                        ->relationship('sumber', 'nama_sumber')
                        ->required(),
                    Forms\Components\Select::make('prospektor_id')
                        ->label('Prospektor')
                        ->relationship('prospektor', 'nama_karyawan')
                        ->required(),
                    Forms\Components\Select::make('status_prospek')
                        ->required()
                        ->label('Status Prospek')
                        ->options([
                            'Diprospek' => 'Diprospek',
                            'Tidak Diprospek' => 'Tidak Diprospek',
                            'Diblokir' => 'Diblokir',
                        ]),
                    Forms\Components\Select::make('branch_id')
                        ->label('Branch')
                        ->relationship('branch', 'name')
                        ->required(),

                ])
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => BranchFilterService::apply($query))
            ->columns([
                Tables\Columns\TextColumn::make('nama_wakif')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hp'),
                Tables\Columns\TextColumn::make('tgl_dapat')
                    ->date(),
                Tables\Columns\TextColumn::make('wa_status'),
                Tables\Columns\TextColumn::make('sumber.nama_sumber')
                    ->sortable()
                    ->label('Sumber'),
                Tables\Columns\TextColumn::make('prospektor.nama_karyawan')
                    ->sortable()
                    ->label('Prospektor'),
                Tables\Columns\TextColumn::make('status_prospek'),
                Tables\Columns\TextColumn::make('branch.name')
                    ->sortable()
                    ->label('Branch'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWakifs::route('/'),
            // 'create' => Pages\CreateWakif::route('/create'),
            // 'edit' => Pages\EditWakif::route('/{record}/edit'),
        ];
    }
}
