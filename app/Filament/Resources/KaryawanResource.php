<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Filament\Resources\Resource;
use function Laravel\Prompts\search;

use Illuminate\Support\Facades\Auth;
use App\Services\BranchFilterService;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KaryawanResource\Pages;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Karyawan';

    protected static ?string $navigationGroup = 'CRM';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('nama_karyawan')
                ->required(),
            Forms\Components\Select::make('jabatan_id')
                ->label('Jabatan')
                ->relationship('jabatan', 'nama_jabatan')
                ->required(),
            Forms\Components\TextInput::make('hp')
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
            Forms\Components\Select::make('branch_id')
                ->label('Branch')
                ->relationship('branch', 'name')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => BranchFilterService::apply($query))
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                ->getStateUsing(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->nama_karyawan) . '&background=random&color=ffffff')
                ->circular()
                ->alignment(Alignment::End),
                Tables\Columns\TextColumn::make('nama_karyawan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan.nama_jabatan')
                    ->sortable()
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('hp')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
