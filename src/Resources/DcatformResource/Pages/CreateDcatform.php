<?php

namespace Solutionforest\FilamentScaffold\Resources\DcatformResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Solutionforest\FilamentScaffold\Models\Dcatform;
use Solutionforest\FilamentScaffold\Resources\DcatformResource;

class CreateDcatform extends CreateRecord
{
    protected static string $resource = DcatformResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        DcatformResource::generateFiles($data);

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        DcatformResource::generateFiles($data);

        return new Dcatform();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
