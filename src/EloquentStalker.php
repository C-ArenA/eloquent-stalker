<?php

namespace CArena\EloquentStalker;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class EloquentStalker
{
    /** @var ModelExpert[] */
    public array $modelExperts = [];

    public function __construct()
    {
        $allPhpFiles = Helper::get_all_php_files_in_directory(app_path(), app_path());
        foreach ($allPhpFiles as $phpFile) {
            $className = Helper::app_path_to_namespace($phpFile, 'App\\');
            try {
                $reflectionClass = new ReflectionClass($className);
            } catch (\Throwable $th) {
                continue;
            }
            if ($reflectionClass->isSubclassOf(Model::class)) {
                $this->modelExperts[] = ModelExpert::fromReflection($reflectionClass);
            }
        }
    }

    public function getModels(): array
    {
        $models = [];
        foreach ($this->modelExperts as $expert) {
            $models[] = $expert->getShortName();
        }

        return $models;
    }

    /**
     * @return ModelExpert[]
     */
    public function getModelExperts(): array
    {
        return $this->modelExperts;
    }

    public function getRelationships(): array
    {
        $relationships = [];
        foreach ($this->modelExperts as $expert) {
            $modelRelationships = [];
            foreach ($expert->getRelationshipExperts() as $relationship) {
                $modelRelationships[] = [
                    'name' => $relationship->getName(),
                    'type' => $relationship->getRelationshipType(),
                    'model' => $relationship->getModelExpert()->getShortName(),
                    'table' => $relationship->getModelExpert()->getTableName(),
                    'relatedModel' => $relationship->getRelatedModelExpert()->getShortName(),
                    'relatedTable' => $relationship->getRelatedModelExpert()->getTableName(),
                ];
            }
            $relationships[$expert->getShortName()] = $modelRelationships;
        }

        return $relationships;
    }
}
