<?php

namespace Solutionforest\FilamentScaffold;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Solutionforest\FilamentScaffold\Testing\TestsFilamentScaffold;

class FilamentScaffoldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-scaffold';

    public static string $viewNamespace = 'filament-scaffold';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        // Testing
        Testable::mixin(new TestsFilamentScaffold());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'solution-forest/filament-scaffold';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
        ];
    }
}
