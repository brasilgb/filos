<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $modelLabel = 'Mensagem';
    protected static ?string $pluralModelLabel = 'Mensagens';
    protected static ?string $navigationLabel = 'Mensagens';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Hidden::make('id')
                            ->default(Message::latest()->first() ? Message::latest()->first()->id + 1 : 1),
                        Forms\Components\Select::make('sender_id')
                            ->label('Remetente')
                            ->options([
                                Auth::user()->id => Auth::user()->name,
                            ])
                            ->rules(['required']),
                        Forms\Components\Select::make('recipient_id')
                            ->label('Destinatário')
                            ->relationship("user", "name")
                            ->rules(['required']),
                        Forms\Components\Textarea::make('message')
                            ->label('Mensagem')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('status')
                            ->label('Status')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(Auth::user()->id)
                    ->default(Auth::user()->name)
                    ->label('Remetente'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Destinatário')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime('y/m/Y')
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
                            ->title('Mensagem editada')
                            ->body('A mensagem foi editada com sucesso.')
                    ),
                Tables\Actions\DeleteAction::make()->label('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Mensagem deletada')
                            ->body('A mensagem foi deletada com sucesso.')
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
            'index' => Pages\ManageMessages::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
