<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SettingPage extends Page
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Outras';
    protected static ?string $pluralModelLabel = 'Outras';
    protected static ?string $navigationLabel = 'Recibos/Mensagens';
    protected static ?string $title = 'Outras configurações';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.setting-page';
}
