<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UrlProjectResource\Pages;
use App\Filament\Resources\UrlProjectResource\RelationManagers;
use App\Models\UrlProject;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UrlProjectResource extends Resource
{
    protected static ?string $model = UrlProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static ?string $navigationLabel = 'Custom Navigation Label';
    protected static ?string $navigationGroup = 'Short_link Tool';
    protected static function getNavigationGroup(): ?string
    {
        return strval(__('short-link::group-link'));
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static function getNavigationBadgeColor(): ?string
{
    return static::getModel()::count() > 10 ? 'secondary' : 'success';
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUrlProjects::route('/'),
            'create' => Pages\CreateUrlProject::route('/create'),
            'edit' => Pages\EditUrlProject::route('/{record}/edit'),
        ];
    }    
}
