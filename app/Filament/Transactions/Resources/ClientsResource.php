<?php

namespace App\Filament\Transactions\Resources;

use App\Filament\Transactions\Resources\ClientsResource\Pages;
use App\Filament\Transactions\Resources\ClientsResource\RelationManagers;
use App\Models\Clients;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientsResource extends Resource
{
    protected static ?string $model = Clients::class;

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('phone')->label('telefone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextInputColumn::make('name')->label('Nome'),
                Tables\Columns\TextInputColumn::make('email'),
                Tables\Columns\TextInputColumn::make('phone')->label('telefone'),
            ])
            ->filters([
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClients::route('/create'),
            'edit' => Pages\EditClients::route('/{record}/edit'),
        ];
    }
}
