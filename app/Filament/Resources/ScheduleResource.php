<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $modelLabel = 'Agendamento';
    protected static ?string $pluralModelLabel = 'Agendamentos';
    protected static ?string $navigationLabel = 'Agendamentos';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Clientes')
                    ->relationship('customer', 'name')
                    ->rules(['required']),
                Forms\Components\DateTimePicker::make('schedules')
                    ->label('Horário da visita')
                    ->rules(['required']),
                Forms\Components\TextInput::make('service')
                    ->label('Serviço requisitado')
                    ->rules(['required'])
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('details')
                    ->label('Detalhes do serviço')
                    ->rules(['required'])
                    ->columnSpanFull(),
                Forms\Components\Select::make('user_id')
                    ->label('Responsável técnico')
                    ->relationship('user', 'name')
                    ->rules(['required']),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        '1' => 'Aberto',
                        '2' => 'Em atendimento',
                        '3' => 'Fechado',
                    ])
                    ->rules(['required']),
                Forms\Components\Textarea::make('observations')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nº Agendamento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedules')
                ->label('Horário da visita')
                    ->dateTime("d/m/Y H:i:s"),
                Tables\Columns\TextColumn::make('responsible_technician')
                ->label('Responsável técnico'),
                Tables\Columns\TextColumn::make('status')
                ->label('Status'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
