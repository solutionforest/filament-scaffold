<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;

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
