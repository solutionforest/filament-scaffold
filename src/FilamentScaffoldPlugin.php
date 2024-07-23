<?php

namespace Solutionforest\FilamentScaffold;

use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentScaffoldPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-scaffold';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            ScaffoldResource::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
