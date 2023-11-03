<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\ComprovantesResource\Pages;
use App\Filament\Manager\Resources\ComprovantesResource\RelationManagers;
use App\Http\Controllers\ProcessarComprovantes;
use App\Models\Comprovantes;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;


class ComprovantesResource extends Resource
{
    protected static ?string $model = Comprovantes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('img_url')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('id_transacao'),
                Tables\Columns\TextColumn::make('valor'),
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('banco'),
                Tables\Columns\ImageColumn::make('img_url'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('data'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Processar')->icon('heroicon-s-arrows-up-down')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        ProcessarComprovantes::getReady();
                    }),
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
            'index' => Pages\ListComprovantes::route('/'),
            'create' => Pages\CreateComprovantes::route('/create'),
            'edit' => Pages\EditComprovantes::route('/{record}/edit'),
        ];
    }
}
