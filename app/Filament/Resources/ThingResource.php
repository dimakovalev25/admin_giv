<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThingResource\Pages;
use App\Filament\Resources\ThingResource\RelationManagers;
use App\Models\Thing;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThingResource extends Resource
{
    protected static ?string $model = Thing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title'),
                Forms\Components\TextInput::make('purpose'),

/*                Repeater::make('Category')
                    ->relationship()
                    ->schema([
                        Select::make('category')
                            ->relationship('category', 'name')
                            ->required(),

                    ])*/

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('description'),
                TextColumn::make('purpose'),
                TextColumn::make('categoryId'),

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
            'index' => Pages\ListThing::route('/'),
            'create' => Pages\CreateThing::route('/create'),
            'edit' => Pages\EditThing::route('/{record}/edit'),
        ];
    }
}
