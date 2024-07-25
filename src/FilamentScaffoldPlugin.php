<?php

namespace Solutionforest\FilamentScaffold;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Solutionforest\FilamentScaffold\Resources\ScaffoldResource;

class FilamentScaffoldPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-scaffold';
    }

    public function register(Panel $panel): void
    {
        if(config('filament-scaffold.enabled', false)) {
            $panel->resources([
                        ScaffoldResource::class
                    ]);
        }
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
