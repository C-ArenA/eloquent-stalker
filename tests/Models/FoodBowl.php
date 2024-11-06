<?php

namespace CArena\EloquentStalker\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodBowl extends Model
{
    public function dog(): BelongsTo{
        return $this->belongsTo(Dog::class);
    }
}
