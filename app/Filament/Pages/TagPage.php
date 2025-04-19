<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TagPage extends Page
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tag-page';

    protected static ?string $modelLabel = 'Etiqueta';
    protected static ?string $pluralModelLabel = 'Etiquetas';
    protected static ?string $navigationLabel = 'Etiquetas';
    protected static ?string $title = 'Imprimir etiquetas';
    protected static ?int $navigationSort = 2;
}
