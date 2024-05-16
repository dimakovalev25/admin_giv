<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThingResource\Pages;
use App\Filament\Resources\ThingResource\RelationManagers;
use App\Models\Thing;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThingResource extends Resource
{
    protected static ?string $model = Thing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

//    protected static ?string $navigationGroup = 'Things';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
/*                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('description')->required()->maxLength(255),
                Forms\Components\TextInput::make('realCost')->required()->maxLength(255),
                Forms\Components\FileUpload::make('images')->required(),
                Select::make('purpose')
                    ->options(['free'=>'free', 'lost'=>'lost', 'found'=>'found', 'rent'=>'rent', 'sell'=>'sell'])
                    ->required(),

                Select::make('categoryId')
                    ->relationship('category', 'shortname')
                    ->required()
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                Select::make('userId')
                    ->relationship('user', 'email')
                    ->required()
                    ->label('User')
                    ->searchable()
                    ->preload(),*/

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn (Thing $record) => $record->description)->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('images')->stacked()->width(80)->height(130),
                TextColumn::make('purpose')->color('primary'),
/*                TextColumn::make('realCost')->color('primary'),*/
                TextColumn::make('category.shortname'),
                TextColumn::make('category.cat1'),
                TextColumn::make('user.email')->copyable()->sortable()->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
