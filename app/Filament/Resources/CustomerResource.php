<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Grid::make()->schema([
                    Forms\Components\TextInput::make('cpf')
                        ->label('CPF/CNPJ')
                        ->extraAlpineAttributes(['x-mask:dynamic' => '$input.length >14 ? \'99.999.999/9999-99\' : \'999.999.999-99\''])
                        ->rule('cpf_ou_cnpj')
                        ->rules(['required']),
                    Forms\Components\DatePicker::make('birth')
                        ->label('Aniversário'),
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->maxLength(255)
                        ->columnSpan(2)
                        ->rules(['required']),
                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->maxLength(50)
                        ->default(null)
                        ->columnSpan(2)
                ])->columns(6),
                Grid::make()->schema([
                    Cep::make('cep')
                        ->viaCep(
                            mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                            errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                            /**
                             * Other form fields that can be filled by ViaCep.
                             * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                             * More information: https://viacep.com.br/
                             */
                            setFields: [
                                'street' => 'logradouro',
                                'number' => 'numero',
                                'complement' => 'complemento',
                                'district' => 'bairro',
                                'city' => 'localidade',
                                'state' => 'uf'
                            ]
                        ),
                    Forms\Components\TextInput::make('state')
                        ->label('UF')
                        ->maxLength(20)
                        ->default(null),
                    Forms\Components\TextInput::make('city')
                        ->label('Cidade')
                        ->maxLength(50)
                        ->default(null)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('district')
                        ->label('Bairro')
                        ->maxLength(50)
                        ->default(null)
                        ->columnSpan(2),
                ])->columns(6),
                Grid::make()->schema([
                    Forms\Components\TextInput::make('street')
                        ->label('Logradouro')
                        ->maxLength(20)
                        ->default(null)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('complement')
                        ->label('Complemento')
                        ->maxLength(80)
                        ->default(null),
                    Forms\Components\TextInput::make('number')
                        ->label('Número')
                        ->numeric()
                        ->default(null),
                ])->columns(4),
                Grid::make()->schema([
                    PhoneNumber::make('phone')
                        ->label('Telefone')
                        ->tel()
                        ->maxLength(20)
                        ->default(null)
                        ->rules(['required']),
                    Forms\Components\TextInput::make('contactname')
                        ->label('Nome do contato')
                        ->maxLength(50)
                        ->default(null)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('whatsapp')
                        ->label('Whatsapp')
                        ->maxLength(50)
                        ->default(null),
                    PhoneNumber::make('contactphone')
                        ->label('Telefone de contato')
                        ->tel()
                        ->maxLength(20)
                        ->default(null),
                ])->columns(5),
                Forms\Components\Textarea::make('observations')
                    ->label('Observações')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->numeric(),
                Tables\Columns\TextColumn::make('name')
                ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                ->label('E-mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                ->label('CPF/CNPJ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                ->label('Telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime('d/m/Y')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Cliente deletado')
                            ->body('O cliente foi deletado com sucesso.')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
