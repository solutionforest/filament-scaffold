<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScaffolds extends ListRecords
{
    protected static string $resource = ScaffoldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
