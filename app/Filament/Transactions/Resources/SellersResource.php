<?php

namespace App\Filament\Transactions\Resources;

use App\Filament\Transactions\Resources\SellersResource\Pages;
use App\Filament\Transactions\Resources\SellersResource\RelationManagers;
use App\Models\Sellers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SellersResource extends Resource
{
    protected static ?string $model = Sellers::class;
    protected static ?string $navigationLabel = 'Vendedores';
    protected static ?string $label = 'Vendedores';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Nome'),
                Forms\Components\TextInput::make('email'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextInputColumn::make('name')->label('Nome'),
                Tables\Columns\TextInputColumn::make('email'),

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
            RelationManagers\TransactionsRelationManager::class, //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSellers::route('/create'),
            'edit' => Pages\EditSellers::route('/{record}/edit'),
        ];
    }
}
