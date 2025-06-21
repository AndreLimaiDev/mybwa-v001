<?php

namespace App\Filament\Resources;

use DateTime;
use Filament\Forms;
use Filament\Tables;
use App\Models\Wakif;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\BranchFilterService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\TransaksiResource\Pages;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Data Transaksi';

    protected static ?string $navigationGroup = 'CRM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Transaksi')
                    ->columns([
                        'xs' => 1,
                        'sm' => 2,
                        'xl' => 3,
                    ])
                    ->description('Sialhkan isi data transaksi dengan benar')
                    ->schema([
                        Select::make('wakif_id')
                            ->label('Hp Wakif')
                            ->relationship('wakif', 'hp')
                            ->searchable()
                            ->preload()
                            ->allowHtml()
                            ->getOptionLabelFromRecordUsing(fn(Wakif $record) => "{$record->nama_wakif} <br/> <span class='text-xs'>{$record->hp}<span/> - <span class='text-xs text-gray-500'>{$record->branch->name}</span>")
                            ->afterStateUpdated(fn($state, $set) => $set('wakif_exists', Wakif::where('hp', $state)->exists()))
                            ->createOptionForm(fn($get) => $get('wakif_exists') ? null : [
                                Forms\Components\TextInput::make('nama_wakif')
                                    ->required(),
                                Forms\Components\TextInput::make('hp')
                                    ->required(),
                                Forms\Components\DatePicker::make('tgl_dapat')
                                    ->label('Tanggal Dapat')
                                    ->required(),
                                Forms\Components\ToggleButtons::make('status')
                                ->options([
                                    'Aktif' => 'Aktif',
                                    'Nonaktif' => 'Nonaktif',
                                ])
                                ->inline()
                                ->required()
                                ->icons([
                                    'Aktif' => 'heroicon-o-check-circle',
                                    'Nonaktif' => 'heroicon-o-x-circle',
                                ]),
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
                            ])->columnSpan(['xl' => 2]),
                        Select::make('petugas_id')
                            ->label('Petugas')
                            ->relationship('petugas', 'nama_karyawan')
                            ->searchable()
                            ->required(),
                        DatePicker::make('tgl_transaksi')
                            ->label('Tanggal Transaksi')
                            ->required()
                            ->native(false)
                            ->default(fn() => now()->format('Y-m-d')),
                        Select::make('jenis_transaksi')
                            ->label('Jenis Transaksi')
                            ->options([
                                'Direct Cash' => 'Direct Cash',
                                'Direct Transfer' => 'Direct Transfer',
                                'Digital Cash' => 'Digital Cash',
                                'Digital Transfer' => 'Digital Transfer',
                            ]),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->collapsible()
                    ->persistCollapsed(),
                Repeater::make('transaksiDetails')
                    ->relationship()
                    ->label('Transaksi Detail')
                    ->schema([
                        Select::make('program_id')
                            ->relationship('program', 'nama_program')
                            ->required(),

                        Select::make('projek_id')
                            ->relationship('projek', 'nama_projek')
                            ->required()
                            ->searchable()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                        TextInput::make('revenue')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2)
                    ])
                    ->columns(3)
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Add Detail')
                    ->reorderable()
                    ->collapsible()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => BranchFilterService::apply($query))
            ->columns([
                TextColumn::make('wakif.nama_wakif')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('wakif.hp')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('petugas.nama_karyawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('branch.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tgl_transaksi')
                    ->sortable()
                    ->since(),
                TextColumn::make('jenis_transaksi')
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'Direct Cash' => 'success',
                        'Direct Transfer' => 'success',
                        'Digital Cash' => 'info',
                        'Digital Transfer' => 'info',
                    })
                    ->icon('heroicon-o-banknotes')
                    ->searchable(),
                TextColumn::make('transaksiDetails.revenue')
                    ->label('Revenue')
                    ->summarize(
                        Sum::make()
                            ->label('Total Revenue')
                            ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    )
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->listWithLineBreaks()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
