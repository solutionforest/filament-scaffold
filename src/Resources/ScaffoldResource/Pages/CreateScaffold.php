<?php

namespace Solutionforest\FilamentScaffold\Resources\ScaffoldResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Solutionforest\FilamentScaffold\Models\Scaffold;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;

class CreateScaffold extends CreateRecord
{
    protected static string $resource = ScaffoldResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        ScaffoldResource::generateFiles($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        ScaffoldResource::generateFiles($data);

        return new Scaffold();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
