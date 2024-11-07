<?php

namespace CArena\EloquentStalker;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ModelExpert extends ReflectionClass
{
    /** @var ModelRelationshipExpert[] */
    private array $relationshipExperts = [];

    public function __construct(object|string $objectOrClass)
    {
        parent::__construct($objectOrClass);
        if (! $this->isSubclassOf(Model::class)) {
            throw new ReflectionException('Is not a model class', 1);
        }
        $this->setRelationshipExperts();
    }

    public static function fromReflection(ReflectionClass $reflection)
    {
        return new self($reflection->getName());
    }

    public function setRelationshipExperts()
    {
        $publicMethods = $this->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($publicMethods as $method) {
            if (ModelRelationshipExpert::isRelationshipMethod($method)) {
                $this->relationshipExperts[] = ModelRelationshipExpert::fromReflection($method, $this);
            }
        }
    }

    /**
     * @return ModelRelationshipExpert[]
     */
    public function getRelationshipExperts(): array
    {
        return $this->relationshipExperts;
    }

    public function getTableName(): string
    {
        return $this->newInstance()->getTable();
    }
}
