<?php

namespace CArena\EloquentStalker;

use Illuminate\Database\Eloquent\Model;

class ModelSchema
{
    public $reflectors = [];

    public function __construct()
    {
        $path = config('eloquent-stalker.models_path');

        foreach (scandir($path) as $contentName) {
            $filename = $path . '/' . $contentName;
            if (is_dir($filename)) {
                continue;
            }

            $modelClassName = substr($filename, 0, -4); // Le quito la extensión
            $modelClassName = str_replace(base_path(), '', $modelClassName); // Dejo sólo el path relativo
            $modelClassName = str_replace('/', '\\', $modelClassName); // Armo el namespace con barra invertida
            $modelClassName = str_replace('\\app\\', 'App\\', $modelClassName); // Remplazo el App namespace a mayúscula
            $modelReflection = new \ReflectionClass($modelClassName);
            if ($modelReflection->isSubclassOf(Model::class)) {
                $this->reflectors[] = $modelReflection;
            }
        }
    }

    public function getRelationships(): array
    {
        $relationships = [];
        foreach ($this->reflectors as $reflector) {
            $relationships[$reflector->getShortName()] = ModelSchema::getModelReflectionRelationships($reflector);
        }
        return $relationships;
    }
    public function getModels(): array
    {
        $models = [];
        foreach ($this->reflectors as $reflector) {
            $models[] = $reflector->getShortName();
        }
        return $models;
    }

    public static function getModelReflectionRelationships(\ReflectionClass $reflection)
    {
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $relationshipMethods = array_filter($methods, function ($method) {
            if ($method->hasReturnType()) {
                $type = $method->getReturnType()->getName();
                return substr($type, 0, 38) ===
                    substr(\Illuminate\Database\Eloquent\Relations\HasMany::class, 0, 38);
            }
            return false;
        });
        $relationships = [];
        foreach ($relationshipMethods as $method) {
            $modelInstance = $reflection->newInstance();
            $methodName = $method->getName();
            $relationshipType = explode('\\', $method->getReturnType()->getName());
            $relatedModelInstance = $modelInstance->$methodName()->getModel();
            $relatedModelName = explode('\\', get_class($relatedModelInstance));
            $relationship = [
                'name' => $methodName,
                'type' => $relationshipType[count($relationshipType) - 1],
                'model' => $relatedModelName[count($relatedModelName) - 1],
                'table' => $relatedModelInstance->getTable(),
            ];
            $relationships[] = $relationship;
        }
        return $relationships;
    }
}
