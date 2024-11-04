<?php

use CArena\EloquentStalker\Commands\EloquentStalkerCommand;
use Illuminate\Console\Command;

use function Pest\Laravel\artisan;

it('can test', function () {

    dd(config('eloquent-stalker.models_path'));
    artisan(EloquentStalkerCommand::class)->execute();
});
