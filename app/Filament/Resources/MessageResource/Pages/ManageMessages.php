<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageMessages extends ManageRecords
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->successNotification(
                Notification::make()
                    ->success()
                    ->title('Mensagem criada')
                    ->body('A mensagem foi criada com sucesso.')
            ),
        ];
    }

}
