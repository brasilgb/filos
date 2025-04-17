<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CompanyPage extends Page
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $pluralModelLabel = 'Empresas';
    protected static ?string $navigationLabel = 'Empresas';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.company-page';
}
