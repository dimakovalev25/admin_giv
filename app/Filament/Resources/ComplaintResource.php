<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $navigationGroup = 'Complaints';


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
                TextColumn::make('user.email')->copyable()->sortable()->searchable(),


                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                    }),


                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('reason')->sortable()->searchable(),

                TextColumn::make('targetUser.email')->copyable()->sortable()->searchable(),
                TextColumn::make('targetThing.title')->copyable()->sortable()->searchable(),


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
            'index' => Pages\ListComplaint::route('/'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
