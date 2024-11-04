<?php

namespace CArena\EloquentStalker\Commands;

use CArena\EloquentStalker\ModelSchema;
use Illuminate\Console\Command;

class EloquentStalkerCommand extends Command
{
    public $signature = 'eloquent-stalker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->alert('Modelos');
        $schema = new ModelSchema();
        $models = $schema->getModels();
        foreach ($models as $model) {
            $this->line($model);
        }
        return self::SUCCESS;
    }
}
