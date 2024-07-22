<?php

namespace Solutionforest\FilamentScaffold\Commands;

use Illuminate\Console\Command;

class FilamentScaffoldCommand extends Command
{
    public $signature = 'filament-scaffold';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
