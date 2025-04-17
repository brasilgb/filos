<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SettingPage extends Page
{
    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Agendamento';
    protected static ?string $pluralModelLabel = 'Agendamentos';
    protected static ?string $navigationLabel = 'Agendamentos';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.setting-page';
}
