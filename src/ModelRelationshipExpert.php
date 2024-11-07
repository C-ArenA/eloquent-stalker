<?php

namespace CArena\EloquentStalker;

use Illuminate\Database\Eloquent\Relations\HasMany;
use ReflectionException;
use ReflectionMethod;

class ModelRelationshipExpert extends ReflectionMethod
{
    public ModelExpert $modelExpert;

    public function __construct(object|string $objectOrMethod, string|null $method = null, ModelExpert|null $modelExpert = null)
    {
        parent::__construct($objectOrMethod, $method);
        if (! ModelRelationshipExpert::isRelationshipMethod($this)) {
            throw new ReflectionException("El método no es de tipo relationship", 1);
        }
        if (isset($modelExpert)) {
            $this->modelExpert = $modelExpert;
        } else {
            $this->modelExpert = ModelExpert::fromReflection($this->getDeclaringClass());
        }
    }

    public static function fromReflection(ReflectionMethod $method, ModelExpert $modelExpert = null)
    {
        $className = $method->getDeclaringClass()->getName();
        $methodName = $method->getName();
        $classMethodName = $className . '::' . $methodName;
        return new self($classMethodName, null, $modelExpert);
    }

    public function getRelationshipType(): string
    {
        $explodedRelationshipName = explode('\\', $this->getReturnType()->getName());
        return $explodedRelationshipName[count($explodedRelationshipName) - 1];
    }

    public function getModelExpert(): ModelExpert
    {
        return $this->modelExpert;
    }

    public function getRelatedModelExpert(): ModelExpert
    {
        $modelInstance = $this->modelExpert->newInstance();
        $relationshipMethodName = $this->getName();
        $relatedModelInstance = $modelInstance->$relationshipMethodName()->getModel();
        return new ModelExpert($relatedModelInstance);
    }

    public static function isRelationshipMethod(ReflectionMethod $method)
    {
        if (!$method->hasReturnType()) {
            return false;
        }

        $type = $method->getReturnType()->getName();

        return substr($type, 0, 38) === substr(HasMany::class, 0, 38);
    }
}
