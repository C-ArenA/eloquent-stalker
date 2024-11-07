<?php

namespace CArena\EloquentStalker\Commands;

use CArena\EloquentStalker\EloquentStalker;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;

class EloquentStalkerCommand extends Command
{
    public $signature = 'eloquent-stalker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->alert('Modelos');
        $stalker = new EloquentStalker;
        $models = $stalker->getModels();
        foreach ($models as $model) {
            $this->line($model);
        }
        $this->alert('Relaciones');
        $relationships = $stalker->getRelationships();
        foreach ($relationships as $model => $modelRelationships) {
            $this->line(' * '.$model.'\'s relationships:');
            table(
                headers: ['Method', 'Type', 'Model', 'Table', 'Related', 'RelatedTable'],
                rows: $modelRelationships
            );
        }

        return self::SUCCESS;
    }
}
