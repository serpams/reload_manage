<?php

namespace App\Filament\Manager\Resources\UsersResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class ObrasRelationManager extends RelationManager
{
    protected static string $relationship = 'ObrasUsers';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('obras_id')
                    ->options(
                        \App\Models\Obras::all()->pluck('obra', 'id')
                    )
                    ->required()->validationAttribute('required')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('obras_id')
            ->columns([
                Tables\Columns\TextColumn::make('obras_id'),
                Tables\Columns\TextColumn::make('obras.obra'),
            ])
            ->filters([
                //
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
            ])
            // ->modifyQueryUsing(function (Builder $query) {
            //     $query->where('user_id', $this->record->getKey());
            // })
        ;
    }
}