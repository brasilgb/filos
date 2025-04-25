<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistResource\Pages;
use App\Models\Checklist;
use App\Models\Setting;
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
        $typeEquipment = Setting::first()->equipmenttype;
        $opcoesArray = explode(',', $typeEquipment);
        $opcoesArray = array_map('trim', $opcoesArray);
        $opcoesFormatadas = array_combine($opcoesArray, $opcoesArray);
        // dd($dataequipment);
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('equipmenttype')
                            ->label('Tipo de equipamento')
                            ->options($opcoesFormatadas)
                            ->helperText('Tipos de equipamentos descritos em recibos e mensagens.')
                            ->rules(['required']),
                        Forms\Components\Textarea::make('checklist')
                            ->label('Checklist para o tipo de equipamento')
                            ->rules(['required'])
                            ->helperText('Checklist de acordo com o tipo de equipamento, separe por vírgula Ex.: botão liga/desliga, microfone, tela.')->required()
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checklist')
                    ->label('Checklist')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime("d/m/Y")
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
