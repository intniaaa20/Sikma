<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\OrderResource\Widgets\OrderStatusChart::class,
        ];
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'sending' => 'Sending',
                        'done' => 'Done',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\DatePicker::make('delivery_date')
                    ->label('Tanggal Pengiriman')
                    ->disabled(),
                Forms\Components\Textarea::make('note')
                    ->label('Pesan dari Customer')
                    ->disabled(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'sending' => 'info',
                        'done' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('Tanggal Pengiriman')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('note')
                    ->label('Catatan')
                    ->limit(40),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'sending' => 'Sending',
                        'done' => 'Done',
                    ]),
                Tables\Filters\Filter::make('history')
                    ->label('History (Selesai)')
                    ->query(fn(Builder $query) => $query->where('status', 'done')),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
