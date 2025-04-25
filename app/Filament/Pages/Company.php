<?php

namespace App\Filament\Pages;

use App\Models\Company as ModelsCompany;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class Company extends Page
{
    use InteractsWithForms;
    public ?array $data = [];

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $pluralModelLabel = 'Empresa';
    protected static ?string $navigationLabel = 'Empresas';
    protected static ?string $title = 'Dados da empresa';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.company';

    public function mount(): void
    {
        $companyData = ModelsCompany::first();
        if (is_null($companyData)) {
            $this->form->fill();
        } else {
            $this->form->fill($companyData->toArray());
        }
    }

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
                                ->maxLength(255)
                                ->rules(['required']),
                            Forms\Components\TextInput::make('companyname')
                                ->label('Razão social')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2)
                                ->rules(['required']),
                            Document::make('cnpj')
                                ->label('CNPJ')
                                ->required()
                                ->maxLength(14)
                                ->columnSpan(2)
                                ->rules(['required']),
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
                                ->rules(['required'])
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
                                ->label('UF'),
                            Forms\Components\TextInput::make('city')
                                ->label('Cidade')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('district')
                                ->label('Bairro')
                                ->columnSpan(2)
                                ->maxLength(255),
                        ])->columns(6),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('street')
                                ->label('Endereço')
                                ->columnSpan(2)
                                ->rules(['required'])
                                ->maxLength(255),
                            Forms\Components\TextInput::make('number')
                                ->label('Número')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('complement')
                                ->label('Complemento')
                                ->columnSpan(2)
                                ->maxLength(255),
                            PhoneNumber::make('telephone')
                                ->label('Telefone')
                                ->rules(['required'])
                                ->tel(),
                        ])->columns(6),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('whatsapp')
                                ->label('Whatsapp'),
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail')
                                ->rules(['required'])
                                ->columnSpan(2)
                                ->email()
                                ->maxLength(50)
                                ->default(null),
                            Forms\Components\TextInput::make('site')
                                ->label('Site')
                                ->columnSpan(2)
                                ->url()
                                ->maxLength(50)
                                ->default(null),
                        ])->columns(5),
                    ])
            ])->statePath('data');
    }

    public function save(ModelsCompany $company): void
    {
        try {
            $companyData = ModelsCompany::first();
            $data = $this->form->getState();
            if (is_null($companyData)) {
                ModelsCompany::create($data);
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
