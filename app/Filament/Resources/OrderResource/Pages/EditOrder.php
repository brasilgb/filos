<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Leandrocfe\FilamentPtbrFormFields\Money;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Cliente editado')
            ->body('A ordem foi editada com sucesso.');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('id')
                                ->label('Nº OS')
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
                                ->label('Orçamento')
                                ->columnSpan(2),
                            Money::make('budget_value')
                                ->label('Valor do orçamento'),
                        ])->columns(3),
                        Grid::make()->schema([
                            Forms\Components\Textarea::make('services_performed')
                                ->label('Serviço executado')
                                ->columnSpan(2),
                            Forms\Components\Textarea::make('parts')
                                ->label('Peças adicionadas'),
                        ])->columns(3),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('parts_value')
                                ->label('Valor das peças')
                                ->prefix('R$')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                }),
                            Forms\Components\TextInput::make('service_value')
                                ->label('Valor do serviço')
                                ->prefix('R$')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                }),
                            Forms\Components\TextInput::make('service_cost')
                                ->label('Custo total')
                                ->prefix('R$')
                                ->readOnly()
                        ])->columns(3),
                        Grid::make()->schema([
                            Forms\Components\Select::make('responsible_technician')
                                ->label('Técnico responsável')
                                ->rules(['required'])
                                ->options([
                                    '1' => 'Anderson',
                                    '2' => 'João',
                                    '3' => 'José',
                                ]),
                            Forms\Components\Select::make('service_status')
                                ->label('Status')
                                ->options([
                                    '1' => 'Ordem aberta',
                                    '2' => 'Orçamento gerado',
                                    '3' => 'Orçamento aprovado',
                                ]),
                        ])->columns(2),

                        Forms\Components\Textarea::make('observations')
                            ->label('Observações')
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        // $padraoAmericanoParts   = str_replace(['.', ','], ['', '.'], $get('parts_value'));
        // $padraoAmericanoServico = str_replace(['.', ','], ['', '.'], $get('service_value'));
        // $padraoAmericanoTotal   = $get('parts_value') + $get('service_value');
        // dd($get('parts_value'));
        $set('service_cost', $get('parts_value') + $get('service_value'));
    }
}
