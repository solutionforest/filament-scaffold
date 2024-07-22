<?php

namespace Solutionforest\FilamentScaffold\Resources\DcatformResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Solutionforest\FilamentScaffold\Resources\DcatformResource;

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
