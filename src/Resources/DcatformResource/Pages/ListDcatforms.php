<?php

namespace Solutionforest\FilamentScaffold\Resources\DcatformResource\Pages;

use Solutionforest\FilamentScaffold\Resources\DcatformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDcatforms extends ListRecords
{
    protected static string $resource = DcatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
