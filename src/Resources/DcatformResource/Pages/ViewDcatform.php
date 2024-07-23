<?php

namespace Solutionforest\FilamentScaffold\Resources\DcatformResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Solutionforest\FilamentScaffold\Resources\DcatformResource;

class ViewDcatform extends ViewRecord
{
    protected static string $resource = DcatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
