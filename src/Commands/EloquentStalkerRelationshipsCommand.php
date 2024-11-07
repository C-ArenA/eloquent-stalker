<?php

namespace CArena\EloquentStalker\Commands;

use CArena\EloquentStalker\EloquentStalker;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;

class EloquentStalkerRelationshipsCommand extends Command
{
    public $signature = 'eloquent-stalker:relationships {modelShortName?}';

    public $description = 'Get a list of all defined models';

    public function handle(): int
    {
        $stalker = new EloquentStalker();
        $this->alert('Relaciones');
        $relationships = $stalker->getRelationships();

        if ($this->argument('modelShortName')) {
            $relationships = array_filter($relationships, function($key){
                return $key == $this->argument('modelShortName');
            }, ARRAY_FILTER_USE_KEY);
        }

        foreach ($relationships as $model => $modelRelationships) {
            $this->line(' * ' . $model . '\'s relationships:');
            table(
                headers: ['Method', 'Type', 'Model', 'Table', 'Related', 'RelatedTable'],
                rows: $modelRelationships
            );
        }

        return self::SUCCESS;
    }
}
