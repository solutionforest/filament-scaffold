<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\HtmlString;
use Solutionforest\FilamentScaffold\Models\Scaffold;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;

class CreateScaffold extends CreateRecord
{
    protected static string $resource = ScaffoldResource::class;

    /********************************************
     * MAKE THE SAVE BUTTON ON 'PAGE' STICKY
     */
    public static bool $formActionsAreSticky = true;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        ScaffoldResource::generateFiles($data);

        return new Scaffold;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('create')
            ->label('Create Scaffold')
            ->requiresConfirmation()
            ->modalHeading('Confirm Scaffold Creation')
            ->modalDescription(new HtmlString("Ensure all scaffold components (resource name, table name, etc.) are set and their creation <b>won't be interrupted</b>.<br><br>Are you ready to create the scaffold?"))
            ->modalSubmitActionLabel('Yes, Confirm')
            ->modalCancelActionLabel('No, Cancel')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalIconColor('warning')
            ->action(fn () => $this->create())
            ->keyBindings(['mod+s']);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}
