<?php

use CArena\EloquentStalker\Facades\EloquentStalker;
use CArena\EloquentStalker\ModelExpert;
use CArena\EloquentStalker\ModelRelationshipExpert;
use CArena\EloquentStalker\Tests\Models\Dog;
use CArena\EloquentStalker\Tests\Models\FoodBowl;
use CArena\EloquentStalker\Tests\Models\User;

it('can extend reflection class', function () {
    $expert = new ModelExpert(User::class);
    expect($expert->getShortName())->toBe('User');
});

it('doesnt reflect a class that is not a model', function () {
    new ModelExpert(EloquentStalker::class);
})->throws(ReflectionException::class);

it('collects model relationship experts', function () {
    $dogExpert = new ModelExpert(Dog::class);
    $foodBowlExpert = new ModelExpert(FoodBowl::class);
    $dogRelationshipExperts = $dogExpert->getRelationshipExperts();
    $foodBowlRelationshipExperts = $foodBowlExpert->getRelationshipExperts();
    expect(count($dogRelationshipExperts))->toBe(3);
    expect(count($foodBowlRelationshipExperts))->toBe(1);
    expect($foodBowlRelationshipExperts[0])->toBeInstanceOf(ModelRelationshipExpert::class);
});

it('knows the name of the related table', function () {
    $dogExpert = new ModelExpert(Dog::class);
    expect($dogExpert->getTableName())->toBe('dogs');
});
