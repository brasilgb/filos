<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()->schema([
                            Forms\Components\Hidden::make('id')
                                ->default(User::latest()->first() ? User::latest()->first()->id + 1 : 1),
                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->rules(['required']),
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail')
                                ->email()
                                ->rules(['required'])
                                ->unique(ignoreRecord: true)
                        ])->columns(2),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('telephone')
                                ->label('Telefone')
                                ->tel(),
                            Forms\Components\TextInput::make('whatsapp')
                                ->label('Whatsapp'),
                        ])->columns(2),
                        Grid::make()->schema([
                            Password::make('password')
                                ->label('Senha')
                                ->password()
                                ->confirmed()
                                ->rules(['min:8'])
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $context): bool => $context === 'create')
                                ->columnSpan(2),
                            Password::make('password_confirmation')
                                ->label('Repita a senha')
                                ->password()
                                ->required(fn(string $context): bool => $context === 'create')
                                ->dehydrated(false)
                                ->rules(['min:8'])
                                ->same('password')
                                ->columnSpan(2),
                            Forms\Components\Select::make('roles')
                                ->label('Função')
                                ->rules(['required'])
                                ->options([
                                    1 => 'Administrador',
                                    2 => 'Usuário',
                                    3 => 'Técnico',
                                ]),
                        ])->columns(5),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Usuário ativo')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('Whatsapp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles')
                    ->label('Função')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            1 => 'Administrador',
                            2 => 'Usuário',
                            3 => 'Técnico',
                        };
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Ativo'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime('d/m/Y')
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
                            ->title('Usuário editado')
                            ->body('O usuário foi editado com sucesso.')
                    ),
                Tables\Actions\DeleteAction::make()->label('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Usuário deletado')
                            ->body('O usuário foi deletado com sucesso.')
                    ),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
