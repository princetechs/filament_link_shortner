<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UrlResource\Pages;
use App\Filament\Resources\UrlResource\RelationManagers;
use App\Helpers\Shortener;
use App\Models\Url;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UrlResource extends Resource
{
    protected static ?string $model = Url::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static function getNavigationGroup(): ?string
    {
        return strval(__('short-link::group-link'));
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                Select::make('project_id')
                 ->relationship('urlProject', 'name')
                 ->createOptionForm([
                    TextInput::make('name')
                        ->required(),
                    Toggle::make('status'),
                    ])
                 ->disablePlaceholderSelection(),
                TextInput::make('org_url')
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    $set('gen_url',$a= Shortener::fullurl(3));
                    $e=explode("/",$a);
                    $set('gen_code',end($e));
                })
                    ->required()
                    ->maxLength(255),
                TextInput::make('gen_url')
                    ->maxLength(255),
                TextInput::make('gen_code')
                    ->maxLength(255),
                Toggle::make('status')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_id'),
                Tables\Columns\TextColumn::make('org_url'),
                Tables\Columns\TextColumn::make('gen_url')
                ->copyable()
                ->copyMessage('Url address copied')
                ->copyMessageDuration(1500)
                // ->prefix('📋 ')
                ->tooltip('click to copy'),
                Tables\Columns\TextColumn::make('gen_code'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
            'index' => Pages\ListUrls::route('/'),
            'create' => Pages\CreateUrl::route('/create'),
            'edit' => Pages\EditUrl::route('/{record}/edit'),
        ];
    }    
}
