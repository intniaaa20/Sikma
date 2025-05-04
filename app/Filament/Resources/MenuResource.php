<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
<<<<<<< HEAD
                Forms\Components\TagsInput::make('categories')
                    ->label('Kategori')
                    ->placeholder('Contoh: ayam, nasi, sambal')
                    ->suggestions(['ayam', 'nasi', 'sambal', 'minuman', 'sayur', 'ikan', 'daging', 'mie', 'cemilan']),
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
<<<<<<< HEAD
                    ->prefix('Rp'),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('menu-images'),
=======
                    ->prefix('$'),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
                Forms\Components\DateTimePicker::make('archived_at'),
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
<<<<<<< HEAD
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image'),
=======
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('archived_at')
                    ->dateTime()
                    ->sortable(),
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
