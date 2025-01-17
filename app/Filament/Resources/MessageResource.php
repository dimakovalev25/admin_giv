<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Config;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Complaints';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('message'),
                TextInput::make('receiver_id'),
                TextInput::make('sender_id'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')->copyable()->sortable()->searchable(),
                TextColumn::make('sender.email')->copyable()->sortable()->searchable(),
                TextColumn::make('sender._id')->copyable()->sortable()->searchable(),
                TextColumn::make('receiver.email')->copyable()->sortable()->searchable(),
//                TextColumn::make('order._id')->copyable()->sortable()->searchable(),


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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('receiver_id', Config::get('app.adminId'));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessage::route('/'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
