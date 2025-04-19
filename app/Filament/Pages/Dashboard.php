<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOrders;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $modelLabel = 'Dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = '';

    
    protected function getHeaderWidgets(): array
    {
        return [
           StatsOrders::class
        ];
    }
    
}
