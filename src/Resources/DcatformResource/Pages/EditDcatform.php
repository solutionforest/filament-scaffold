<?php

namespace Solutionforest\FilamentScaffold\Resources\DcatformResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Solutionforest\FilamentScaffold\Resources\DcatformResource;

class EditDcatform extends EditRecord
{
    protected static string $resource = DcatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
