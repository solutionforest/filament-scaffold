<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScaffold extends EditRecord
{
    protected static string $resource = ScaffoldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
