<?php

namespace App\Filament\Pages;

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

class TagPage extends Page
{
    use InteractsWithForms;
    public ?array $data = [];

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
                            Forms\Components\TextInput::make('tag')
                                ->label('Etiqueta')
                                ->helperText('Texto da etiqueta'),
                            Forms\Components\TextInput::make('tag2')
                                ->label('Etiqueta 2')
                                ->helperText('Texto da etiqueta 2'),
                            Forms\Components\TextInput::make('tag3')
                                ->label('Etiqueta 2')
                                ->helperText('Texto da etiqueta 3')
                        ])->columns(3),
                    ]),
                // Actions::make([
                //     Action::make('imprimir')
                //         ->label('Imprime etiquetas0000')
                //         ->icon('heroicon-o-printer')
                //         ->url(function ($data) {
                //             return route('printer-register', $data);
                //         })
                //         ->openUrlInNewTab()
                // ]),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('imprimir')
                ->label('Imprime etiquetas')
                ->icon('heroicon-o-printer')
                ->url(function (array $data) {
                    // app()->call('App\Http\Controllers\TagPageController@printTags', ['formData' => $data]);
                    return route('printer-register', ['formData' => $data]);
                })
                ->openUrlInNewTab(),
        ];
    }
    // ->url(fn ($record) => route('printer-register', ['record' => $record]))

    // public function printTag(Get $get)
    // {

    //     $tags = [
    //         'tag' => $get('tag'),
    //         'tag2' => $get('tag2'),
    //         'tag3' => $get('tag3'),
    //     ];
    //     return view('filament.pages.print-tag', compact($tags));
    // }
}
