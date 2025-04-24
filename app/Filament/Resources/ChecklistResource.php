<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistResource\Pages;
use App\Models\Checklist;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChecklistResource extends Resource
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Checklist';
    protected static ?string $pluralModelLabel = 'Checklists';
    protected static ?string $navigationLabel = 'Checklists';
    protected static ?string $title = 'Checklists';
    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('equipmenttype')
                            ->label('Tipo de equipamento')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('checklist')
                            ->label('Checklist')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipmenttype')
                    ->label('Tipo de equipamento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('checklist')
                    ->label('Checklist')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criação')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Checklist editado')
                            ->body('O checklist foi editado com sucesso.')
                    ),
                Tables\Actions\DeleteAction::make()->label('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Checklist deletado')
                            ->body('O checklist foi deletado com sucesso.')
                    ),
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
            'index' => Pages\ManageChecklists::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
