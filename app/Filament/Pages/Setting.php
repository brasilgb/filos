<?php

namespace App\Filament\Pages;

use App\Models\Setting as ModelsSetting;
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
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class Setting extends Page
{
    use InteractsWithForms;
    public ?array $data = [];

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Outras';
    protected static ?string $pluralModelLabel = 'Outras';
    protected static ?string $navigationLabel = 'Recibos/Mensagens';
    protected static ?string $title = 'Outras configurações';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.setting';


    public function mount(): void
    {
        $settingData = ModelsSetting::first();
        if (is_null($settingData)) {
            $this->form->fill();
        } else {
            $this->form->fill($settingData->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('receivingequipment')
                    ->label('Recibo de recebimento do equipamento')
                    ->helperText('Condições de recebimento do equipamento'),
                Forms\Components\Textarea::make('equipmentdelivery')
                    ->label('Recibo de entrega do equipamento')
                    ->helperText('Condições de entrega do equipamento'),
                Forms\Components\Textarea::make('budgetissuance')
                    ->label('Recibo de emissão de orçamento')
                    ->helperText('Condições de emissão de orçamento'),
                Forms\Components\Textarea::make('generatedbudget')
                    ->label('Aviso de orçamento gerado')
                    ->helperText('Mensagem enviada pelo Whatsapp para o cliente quando o orçamento é gerado'),
                Forms\Components\Textarea::make('servicecompleted')
                    ->label('Aviso de serviço concluído')
                    ->helperText('Mensagem enviada pelo Whatsapp para o cliente quando o serviço é concluído'),
                Forms\Components\Textarea::make('equipmenttype')
                    ->label('Lista de tipos de equipamentos')
                    ->helperText('Separe os tipos de equipamentos por vírgula. Ex: Impressora, Notebook, Monitor')
                    ->placeholder('Impressora, Notebook, Monitor')
            ])->statePath('data');
    }

    public function save(ModelsSetting $setting): void
    {
        try {
            $settingData = ModelsSetting::first();
            $data = $this->form->getState();
            if (is_null($settingData)) {
                ModelsSetting::create($data);
            } else {
                $setting->where('id', $settingData->id)->update($data);
            }
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Dados Salvos')
            ->body('Dados das configurações salvos com sucesso.')
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
