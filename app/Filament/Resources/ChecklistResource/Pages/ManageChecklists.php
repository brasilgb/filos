<?php

namespace App\Filament\Resources\ChecklistResource\Pages;

use App\Filament\Resources\ChecklistResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageChecklists extends ManageRecords
{
    protected static string $resource = ChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->successNotification(
                Notification::make()
                    ->success()
                    ->title('Checklist criado')
                    ->body('O checklist foi criado com sucesso.')
            ),
        ];
    }
}
