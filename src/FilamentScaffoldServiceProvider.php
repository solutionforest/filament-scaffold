<?php

namespace Solutionforest\FilamentScaffold;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentScaffoldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-scaffold';

    public static string $viewNamespace = 'filament-scaffold';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
