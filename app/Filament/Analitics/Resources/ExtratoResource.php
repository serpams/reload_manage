<?php

namespace App\Filament\Analitics\Resources;

use App\Filament\Analitics\Resources\ExtratoResource\Pages;
use App\Filament\Analitics\Resources\ExtratoResource\RelationManagers;
use App\Models\Extrato;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtratoResource extends Resource
{
    protected static ?string $model = Extrato::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtratos::route('/'),
            'create' => Pages\CreateExtrato::route('/create'),
            'edit' => Pages\EditExtrato::route('/{record}/edit'),
        ];
    }    
}
