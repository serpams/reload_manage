<?php

namespace App\Filament\Transactions\Resources\SellersResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Query\Builder as Build;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'Transactions';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('data')
                    ->required()->readOnly(true)->default(true),
                Forms\Components\Select::make('type')
                    ->options([
                        'compra' => 'compra',
                        'venda' => 'venda',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('valor'),
                Forms\Components\TextInput::make('cotacao')->required(),
                Forms\Components\Select::make('clients_id')
                    ->relationship('clients', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('nome')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email ')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefone')
                            ->tel(),
                    ])
                    ->required(),
                Forms\Components\Select::make('sellers_id')
                    ->relationship('sellers', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Select::make('sites_id')
                    ->relationship('sites', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required()->live(),
                Forms\Components\Hidden::make('users_id')
                    ->required()
                    ->default(auth()->user()->id),
                Forms\Components\Checkbox::make('repasse')
                    ->default(0),
                Forms\Components\Checkbox::make('caixa_inicial')
                    ->default(0),
                Forms\Components\TextInput::make('observacao')->label('Observação'),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('repasse'),
                Tables\Columns\TextColumn::make('users.name')->label('Cadastrado por:'),
                Tables\Columns\TextColumn::make('data')->dateTime('d/m/y'),
                Tables\Columns\TextColumn::make('valor')->label('Fichas $')->money('USD'),
                Tables\Columns\TextColumn::make('cotacao')->money('BRL')->label('Cotação'),
                // Tables\Columns\TextColumn::make('Total')
                // ->state(function (Model $record){
                //     $valor= $record->valor * $record->cotacao;
                //     $valor = 'R$ '.number_format($valor, 2, ',', '.');

                //     return $valor;
                // }),
                Tables\Columns\TextColumn::make('cotacao')->money('BRL')
                    ->summarize([Average::make()->label('cotacao Media'), Range::make()->label('Minimo e Maximo')]),

                TextColumn::make('valor_convertido')
                    ->summarize(
                        [
                            Sum::make()->query(fn (Build $query) => $query->where('type', 'compra'))->label('Total Compra'),
                            Sum::make()->query(fn (Build $query) => $query->where('type', 'venda'))->label('Total Venda'),
                        ]
                    ),
                Tables\Columns\TextColumn::make('valor_convertido_considerado')->money('BRL')
                    ->summarize(Sum::make()->label('Lucro entre ( Compra - venda )'))->label('Operacao'),
            ])
            ->filters([
                Filter::make('e_repasse')
                    ->query(fn (Builder $query): Builder => $query->where('repasse', true)),
                SelectFilter::make('type')
                    ->options([
                        'compra' => 'compra',
                        'venda' => 'venda',
                    ])->label('Tipo'),
                Filter::make('created_at')
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
                    })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
}
