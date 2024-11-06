<?php

namespace CArena\EloquentStalker\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dog extends Model
{
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function toys(): HasMany
    {
        return $this->hasMany(Toy::class);
    }

    public function foodBowl(): HasOne
    {
        return $this->hasOne(FoodBowl::class);
    }

    public function sayGuau(): string
    {
        return 'guau';
    }
}
