<?php

namespace App\Filament\Transactions\Resources;

use App\Filament\Transactions\Resources\SitesResource\Pages;
use App\Filament\Transactions\Resources\SitesResource\RelationManagers;
use App\Filament\Transactions\Widgets\SitesWidgets;
use App\Models\Sites;
use App\Models\Transactions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SitesResource extends Resource
{
    protected static ?string $model = Sites::class;
    protected static ?string $navigationLabel = 'Sites';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SitesWidgets::class,
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Site|Conta'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Site|Conta'),
                Tables\Columns\TextColumn::make('compras')
                ->state(function (Model $record) {
                    $valor = Transactions::where('sites_id',$record->id)->where('type','compra')->where('repasse', 0)->sum('valor') ;
                    $valor = '$ '.number_format($valor, 2, ',', '.');
                    return $valor;
                }),

                Tables\Columns\TextColumn::make('vendas')
                ->state(function (Model $record) {
                    $valor = Transactions::where('sites_id',$record->id)->where('type','venda')->where('repasse', 0)->sum('valor') ;
                    $valor = '$ '.number_format($valor, 2, ',', '.');
                    return $valor;
                }),
                Tables\Columns\TextColumn::make('Compras Repasse')
                ->state(function (Model $record){
                    $valor = Transactions::where('sites_id',$record->id)->where('type','compra')->where('repasse', 1)->sum('valor') ;
                    $valor = '$ '.number_format($valor, 2, ',', '.');
                    return $valor;
                }),
                Tables\Columns\TextColumn::make('Vendas Repasse')
                ->state(function (Model $record){
                    $valor = Transactions::where('sites_id',$record->id)->where('type','venda')->where('repasse', 1)->sum('valor') ;
                    $valor = '$ '.number_format($valor, 2, ',', '.');
                    return $valor;
                })

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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSites::route('/create'),
            'edit' => Pages\EditSites::route('/{record}/edit'),
        ];
    }

}
