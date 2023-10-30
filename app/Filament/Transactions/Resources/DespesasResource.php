<?php

namespace App\Filament\Transactions\Resources;

use App\Filament\Transactions\Resources\DespesasResource\Pages;
use App\Filament\Transactions\Resources\DespesasResource\RelationManagers;
use App\Models\Despesas;
use App\Models\Expenses;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DespesasResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Despesas';
    protected static ?string $label = 'Despesas';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([

                            Forms\Components\TextInput::make('descricao')
                            ->required()
                            ->maxLength(255),
                        ])
                         ,
                    Forms\Components\Section::make('Infos financeiras')
                        ->schema([
                            Forms\Components\Select::make('accounts_id')
                            ->relationship('accounts', 'banco')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('banco')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                            Forms\Components\TextInput::make('valor')
                                ->label('Valor')
                                ->numeric()
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                ->required(),

                                Forms\Components\Hidden::make('users_id')
                                ->required()
                                ->default(auth()->user()->id),

                        ])
                        ->columns(2),
                ])
                ->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Forms\Components\DatePicker::make('data')
                         ->required(),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])
        ->columns(3);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('accounts.banco')->label('Banco'),
                Tables\Columns\TextColumn::make('users.name')->label('cadastro por'),
                Tables\Columns\TextColumn::make('descricao')->label('descricao'),
                Tables\Columns\TextColumn::make('valor')->label('Valor')->money('BRL')->label('Valor'),
                Tables\Columns\TextColumn::make('data')->label('Data Operacao')->dateTime('d/m/y'),
                Tables\Columns\TextColumn::make('created_at')->label('Cadastrado em')->dateTime('d/m/y'),

            ])
            ->filters([
                SelectFilter::make('accounts')
                ->relationship('accounts', 'banco')
                ->searchable()
                ->preload(),
                SelectFilter::make('users')
                ->relationship('users', 'name')
                ->searchable()
                ->preload(),
                Filter::make('data')
                    ->form([
                        DatePicker::make('data_inicio'),
                        DatePicker::make('data_fim'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['data_inicio'],
                                fn (Builder $query, $date): Builder => $query->whereDate('data', '>=', $date),
                            )
                            ->when(
                                $data['data_fim'],
                                fn (Builder $query, $date): Builder => $query->whereDate('data', '<=', $date),
                            );
                    }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListDespesas::route('/'),
            'create' => Pages\CreateDespesas::route('/create'),
            'edit' => Pages\EditDespesas::route('/{record}/edit'),
        ];
    }
}
