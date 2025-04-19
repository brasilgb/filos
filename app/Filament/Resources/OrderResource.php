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

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    
    protected static ?string $modelLabel = 'Ordem';
    protected static ?string $pluralModelLabel = 'Ordens';
    protected static ?string $navigationLabel = 'Ordens';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('equipment')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('model')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\Textarea::make('defect')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('state_conservation')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('accessories')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('budget_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('budget_value')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('service_status')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('delivery_forecast'),
                Forms\Components\Textarea::make('observations')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('services_performed')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('parts')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('parts_value')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('service_value')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('service_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\DateTimePicker::make('delivery_date'),
                Forms\Components\TextInput::make('responsible_technician')
                    ->maxLength(50)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('budget_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_forecast')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parts_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible_technician')
                    ->searchable(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
