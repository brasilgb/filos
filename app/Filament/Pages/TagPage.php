<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\TagPage as ModelsTagPage;
// use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Contracts\HasForms;

class TagPage extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tag-page';

    protected static ?string $modelLabel = 'Etiqueta';
    protected static ?string $pluralModelLabel = 'Etiquetas';
    protected static ?string $navigationLabel = 'Etiquetas';
    protected static ?string $title = 'Imprimir etiquetas';
    protected static ?int $navigationSort = 2;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('starting-order')
                                ->label('Ordem inicial')
                                ->default(Order::first()->id + 1)
                                ->numeric()
                                ->helperText('Oredem inicial para impressão'),
                            Forms\Components\TextInput::make('number-pages')
                                ->label('Número de página')
                                ->default(1)
                                ->live(true)
                                ->helperText('Número de páginas com etiquetas a serem impressas')
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::tagsTotals($get, $set);
                                }),
                            Forms\Components\TextInput::make('ending-order')
                                ->label('Ordem Final')
                                ->default(Order::first()->id + 96)
                                ->readOnly()
                                ->helperText('Número de etiquetas a serem impressas')
                        ])->columns(3),
                    ])
            ])->statePath('data');
    }


    public static function tagsTotals(Get $get, Set $set): void
    {
        $set('ending-order', (($get('starting-order') - 1) + 96) * $get('number-pages'));
    }

    //starting order, ending order, number of pages
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Imprimir etiquetas')
                ->icon('heroicon-o-printer')
                ->openUrlInNewTab()
                ->submit('save'),
        ];
    }
    public function save()
    {
        $formData = $this->form->getState();
        $url = URL::route('printer-register', ['tagi' => $formData['starting-order'], 'tagf' => $formData['ending-order']]); // Passa os dados como array associativo
        return redirect()->to($url);
    }
}
