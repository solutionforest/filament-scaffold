<?php

namespace Solutionforest\FilamentScaffold\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Solutionforest\FilamentScaffold\FilamentScaffold
 */
class FilamentScaffold extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Solutionforest\FilamentScaffold\FilamentScaffold::class;
    }
}
