<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdentityDocumentResource\Pages;
use App\Filament\Resources\IdentityDocumentResource\RelationManagers;
use App\Models\IdentityDocument;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IdentityDocumentResource extends Resource
{
    protected static ?string $model = IdentityDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Identity Document';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->options(['pending'=>'pending', 'resolved'=>'resolved', 'rejected'=>'rejected'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                TextColumn::make('_id')->copyable()->sortable()->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                    }),

                Tables\Columns\ImageColumn::make('images')->stacked()->width(300)->height(430),
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
            'index' => Pages\ListIdentityDocument::route('/'),
            'edit' => Pages\EditIdentityDocument::route('/{record}/edit'),
        ];
    }
}
