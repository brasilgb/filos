<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cliente criado com sucesso!';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Ordem criada')
            ->body('A ordem foi criada com sucesso.');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    Forms\Components\TextInput::make('id')
                        ->label('Nº OS')
                        ->default(Order::latest()->first() ? Order::latest()->first()->id + 1 : 1)
                        ->readOnly(),
                    Forms\Components\Select::make('customer_id')
                        ->label('Clientes')
                        ->relationship("customer", "name")
                        ->rules(['required'])
                        ->columnSpan(2),
                    Forms\Components\Select::make('equipment')
                        ->label('Tipo de equipamento')
                        ->options([
                            1 => 'teste'
                        ])->columnSpan(2)
                        ->rules(['required'])
                ])->columns(5),
                Grid::make()->schema([
                    Forms\Components\TextInput::make('model')
                        ->label('Modelo')
                        ->maxLength(50)
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('password')
                        ->label('Senha do equipamento')
                        ->maxLength(50),
                    Forms\Components\DatePicker::make('delivery_forecast')
                        ->label('Previsão de entrega'),
                ])->columns(4),
                Grid::make()->schema([
                    Forms\Components\Textarea::make('defect')
                        ->label('Defeito relatado')
                        ->rules(['required']),
                    Forms\Components\Textarea::make('state_conservation')
                        ->label('Estado de conservação'),
                    Forms\Components\Textarea::make('accessories')
                        ->label('Acessórios'),
                ])->columns(3),
                Grid::make()->schema([
                    Forms\Components\Textarea::make('budget_description')
                        ->label('Pré-orçamento')
                        ->columnSpan(2),
                    Forms\Components\TextInput::make('budget_value')
                        ->label('Valor do pré-orçamento')
                        ->prefix('R$')
                        ->default('0'),
                    Forms\Components\Select::make('service_status')
                        ->label('Status')
                        ->default(1)
                        ->options([
                            '1' => 'Ordem aberta',
                            '2' => 'Orçamento gerado',
                            '3' => 'Orçamento aprovado',
                        ]),
                ])->columns(4),
                Forms\Components\Textarea::make('observations')
                    ->label('Observações')
                    ->columnSpanFull(),
            ]);
    }
}
