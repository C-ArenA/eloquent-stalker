<?php

namespace CArena\EloquentStalker\Commands;

use CArena\EloquentStalker\EloquentStalker;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;

class EloquentStalkerModelsCommand extends Command
{
    public $signature = 'eloquent-stalker:models';

    public $description = 'Get a list of all defined models';

    public function handle(): int
    {
        $this->alert('Models');
        $stalker = new EloquentStalker();
        $experts = $stalker->getModelExperts();
        $models = [];
        foreach ($experts as $expert) {
            $models[] = [
                'name' => $expert->getShortName(),
                'table' => $expert->getTableName(),
                'relationships' => count($expert->getRelationshipExperts()),
                'class' => $expert->getName()
            ];
        }

        table(
            headers: ['Name', 'Table', '#Rels', 'Class'],
            rows: $models
        );

        return self::SUCCESS;
    }
}
