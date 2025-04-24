<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class CompanyPage extends Page
{

    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $pluralModelLabel = 'Empresa';
    protected static ?string $navigationLabel = 'Empresas';
    protected static ?string $title = 'Dados da empresas';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.company-page';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('shortname')
                                ->label('Nome curto da empresa')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('companyname')
                                ->label('Razão social')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('cnpj')
                                ->label('CNPJ')
                                ->required()
                                ->maxLength(14)
                                ->columnSpan(2),
                        ])->columns(5),
                        Forms\Components\FileUpload::make('logo')
                            ->disk('public')
                            ->directory('logo')
                            ->visibility('public')
                            ->label('Logotipo')
                            ->image(),
                        Grid::make()->schema([
                            Cep::make('cep')
                                ->label('CEP')
                                ->viaCep(
                                    mode: 'suffix',
                                    errorMessage: 'CEP inválido.',
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
                                ->label('Estado'),
                            Forms\Components\TextInput::make('city')
                                ->label('Cidade')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('district')
                                ->label('Bairro')
                                ->maxLength(255),
                        ])->columns(4),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('street')
                                ->label('Endereço')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('number')
                                ->label('Número')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('complement')
                                ->label('Complemento')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('telephone')
                                ->label('Telefone')
                                ->tel(),
                        ])->columns(4),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('whatsapp')
                                ->label('Whatsapp'),
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail')
                                ->email()
                                ->maxLength(50)
                                ->default(null),
                            Forms\Components\TextInput::make('site')
                                ->label('Site')
                                ->url()
                                ->maxLength(50)
                                ->default(null),
                        ])->columns(3),
                    ])
            ]);
    }

    public function save(CompanyPage $company): void
    {
        try {
            $companyData = CompanyPage::first();
            $data = $this->form->getState();
            if (is_null($companyData)) {
                CompanyPage::create($data);
            } else {
                $company->where('id', $companyData->id)->update($data);
            }
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Dados Salvos')
            ->body('Dados do site salvos com sucesso.')
            ->send();
        //  Notification::make()
        //     ->success()
        //     ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
        //     ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
}
