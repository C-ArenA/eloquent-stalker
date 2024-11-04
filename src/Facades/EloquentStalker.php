<?php

namespace CArena\EloquentStalker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CArena\EloquentStalker\EloquentStalker
 */
class EloquentStalker extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CArena\EloquentStalker\EloquentStalker::class;
    }
}
