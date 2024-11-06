<?php

use CArena\EloquentStalker\ModelExpert;
use CArena\EloquentStalker\ModelRelationshipExpert;
use CArena\EloquentStalker\Tests\Models\Dog;
use CArena\EloquentStalker\Tests\Models\FoodBowl;

it('creates an instance', function () {
    $modelClassName = Dog::class;
    $relationhipMethodName = 'foodBowl';
    $instance = new ModelRelationshipExpert($modelClassName.'::'.$relationhipMethodName);
    expect($instance)->toBeInstanceOf(ModelRelationshipExpert::class);
});

it('throws an error when method is not from a models relationhip', function () {
    $modelClassName = Dog::class;
    $relationhipMethodName = 'sayGuau';
    new ModelRelationshipExpert($modelClassName.'::'.$relationhipMethodName);
})->throws(ReflectionException::class);

it('creates an instance from a reflection method', function () {
    $modelExpert = new ModelExpert(FoodBowl::class);
    $relationshipReflectionMethods = $modelExpert->getRelationshipReflectionMethods();
    $relationshipExpert = ModelRelationshipExpert::fromReflection($relationshipReflectionMethods[0]);
    expect($relationshipExpert)->toBeInstanceOf(ModelRelationshipExpert::class);
});

it('returns the relationship type', function () {
    $modelClassName = Dog::class;

    $foodBowlRelationhipMethodName = 'foodBowl';
    $ownerRelationhipMethodName = 'owner';
    $toysRelationhipMethodName = 'toys';

    $foodBowlRelationshipType = 'HasOne';
    $ownerRelationshipType = 'BelongsTo';
    $toysRelationshipType = 'HasMany';

    $foodBowlRelationshipExpert = new ModelRelationshipExpert($modelClassName.'::'.$foodBowlRelationhipMethodName);
    $ownerRelationshipExpert = new ModelRelationshipExpert($modelClassName.'::'.$ownerRelationhipMethodName);
    $toysRelationshipExpert = new ModelRelationshipExpert($modelClassName.'::'.$toysRelationhipMethodName);

    expect($foodBowlRelationshipExpert->getRelationshipType())->toBe($foodBowlRelationshipType);
    expect($ownerRelationshipExpert->getRelationshipType())->toBe($ownerRelationshipType);
    expect($toysRelationshipExpert->getRelationshipType())->toBe($toysRelationshipType);
});

it('has a default related model expert', function () {
    $foodBowlRelationshipWithoutDefinedExpert = new ModelRelationshipExpert(Dog::class.'::'.'foodBowl');
    $modelExpert = $foodBowlRelationshipWithoutDefinedExpert->getModelExpert();
    expect($modelExpert)->toBeInstanceOf(ModelExpert::class);
    expect($modelExpert->getShortName())->toBe('Dog');
});

it('finds the related model expert', function () {
    $foodBowlRelationship = new ModelRelationshipExpert(Dog::class.'::'.'foodBowl');
    $relatedModelExpert = $foodBowlRelationship->getRelatedModelExpert();
    expect($relatedModelExpert)->toBeInstanceOf(ModelExpert::class);
    expect($relatedModelExpert->getShortName())->toBe('FoodBowl');
});
