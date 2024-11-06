<?php

namespace CArena\EloquentStalker;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;

class ModelExpert extends ReflectionClass
{
    public function __construct(object|string $objectOrClass)
    {
        parent::__construct($objectOrClass);
        if (! $this->isSubclassOf(Model::class)) {
            throw new ReflectionException('Is not a model class', 1);
        }
    }

    public static function fromReflection(ReflectionClass $reflection)
    {
        return new self($reflection->getName());
    }

    public function getRelationshipReflectionMethods(): array
    {
        $publicMethods = $this->getMethods(\ReflectionMethod::IS_PUBLIC);

        return array_filter($publicMethods, [ModelRelationshipExpert::class, 'isRelationshipMethod']);
    }

    public function getModelRelationshipExperts(): array
    {
        $relationshipExperts = [];
        foreach ($this->getRelationshipReflectionMethods() as $reflectionMethod) {
            $relationshipExperts[] = ModelRelationshipExpert::fromReflection($reflectionMethod, $this);
        }

        return $relationshipExperts;
    }

    public function getTableName(): string
    {
        return $this->newInstance()->getTable();
    }
}
