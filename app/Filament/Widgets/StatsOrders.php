<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOrders extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuários', User::count())
                ->description('Usuários e clientes')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Categorias', User::count())
                ->description('Categorias produtos e serviços')
                ->descriptionIcon('heroicon-o-tag', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            Stat::make('Serviços', User::count())
                ->description('Nossos serviços')
                ->descriptionIcon('heroicon-o-wrench-screwdriver', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
            Stat::make('Produtos', User::count())
                ->description('Nossos produtos')
                ->descriptionIcon('heroicon-o-device-phone-mobile', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
        ];
    }
}
