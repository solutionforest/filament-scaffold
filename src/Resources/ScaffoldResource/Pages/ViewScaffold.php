<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;

class ViewScaffold extends ViewRecord
{
    protected static string $resource = ScaffoldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
