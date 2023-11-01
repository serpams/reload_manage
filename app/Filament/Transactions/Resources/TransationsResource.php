<?php

namespace App\Filament\Transactions\Resources;

use App\Filament\Transactions\Resources\TransationsResource\Pages;
use App\Filament\Transactions\Resources\TransationsResource\RelationManagers;
use App\Filament\Transactions\Widgets\WidgetTransactions;
use App\Models\Transactions;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Build;

class TransationsResource extends Resource
{
    protected static ?string $model = Transactions::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrows-up-down';
    protected static ?string $navigationLabel = 'Transações';
    protected static ?string $label = 'Transações';
    protected ?string $subheading = 'Custom Page Subheading';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getWidgets(): array
    {
        return [
            WidgetTransactions::class,
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('type')
                                ->label('Tipo')
                                    ->options([
                                        'compra' => 'Compra',
                                        'venda' => 'Venda',
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('sites_id')
                                    ->label('Conta ficha')
                                    ->relationship('sites', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->required()->live(),

                            ])
                            ->columns(2),


                        Forms\Components\Section::make('Valores')
                            ->schema([
                                Forms\Components\TextInput::make('valor')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                Forms\Components\TextInput::make('cotacao')
                                    ->label('Cotação')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                            ])
                            ->columns(2),


                        Forms\Components\Section::make('Outras Infos')
                            ->schema([
                                Forms\Components\Checkbox::make('repasse')
                                    ->default(0),
                                Forms\Components\Checkbox::make('caixa_inicial')
                                    ->default(0),
                                Forms\Components\TextInput::make('observacao')->label('Observação'),

                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->label('Data Criação')
                            ->schema([
                                Forms\Components\DateTimePicker::make('data')
                                    ->default(now())
                                    ->readOnly(true)
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Vincular')
                            ->schema([
                                Forms\Components\Select::make('clients_id')
                                    ->label('Cliente')
                                    ->relationship('clients', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email address')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Phone number')
                                            ->tel(),
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('sellers_id')
                                    ->label('Vendedor')
                                    ->relationship('sellers', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Hidden::make('users_id')
                                    ->required()
                                    ->default(auth()->user()->id)

                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Tipo'),
                Tables\Columns\TextColumn::make('repasse')->label('RP'),
                Tables\Columns\TextColumn::make('users.name')->label('Usuário'),
                Tables\Columns\TextColumn::make('sites.name')->label('Conta ficha'),
                Tables\Columns\TextColumn::make('data')->dateTime('d/m/y H:i')->label('Data Criação'),
                Tables\Columns\TextColumn::make('valor')->label('Fichas ($)')->money('USD')->summarize(
                    [
                        Sum::make()->query(fn (Build $query) => $query->where('type', 'compra'))->label('Total Compra $')->money('USD'),
                        Sum::make()->query(fn (Build $query) => $query->where('type', 'venda'))->label('Total Venda $')->money('USD'),
                    ]
                ),
                Tables\Columns\TextColumn::make('cotacao')->money('BRL')->label('Cotação'),
                // Tables\Columns\TextColumn::make('Total')
                // ->state(function (Model $record){
                //     $valor= $record->valor * $record->cotacao;
                //     $valor = 'R$ '.number_format($valor, 2, ',', '.');

                //     return $valor;
                // }),
                Tables\Columns\TextColumn::make('cotacao')->money('BRL')
                    ->summarize([Average::make()->label('Cotacao Media'), Range::make()->label('Minimo e Maximo')]),

                TextColumn::make('valor_convertido')
                    ->summarize(
                        [
                            Sum::make()->query(fn (Build $query) => $query->where('type', 'compra'))->label('Total Compra')->money('BRL'),
                            Sum::make()->query(fn (Build $query) => $query->where('type', 'venda'))->label('Total Venda')->money('BRL'),
                        ]
                    )->money('BRL'),
                Tables\Columns\TextColumn::make('valor_convertido_considerado')
                    ->summarize(Sum::make()->label('Lucro entre ( Compra - venda )')->money('BRL'))->label('Operacao')->money('BRL'),
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
                    }),
                SelectFilter::make('sites')
                    ->relationship('sites', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('sellers')->label('Vendedor')
                    ->relationship('sellers', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('clients')->label('Cliente')
                    ->relationship('clients', 'name')
                    ->searchable()
                    ->preload()
            ])->filtersFormColumns(3)
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

    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'clients.name'];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransations::route('/'),
            'create' => Pages\CreateTransations::route('/create'),
            'edit' => Pages\EditTransations::route('/{record}/edit'),
        ];
    }
}
