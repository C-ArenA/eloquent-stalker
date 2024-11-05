<?php

use CArena\EloquentStalker\Http\Controllers\EloquentStalkerController;
use CArena\EloquentStalker\Http\Middleware\EnsureValidEnvironment;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('eloquent-stalker.prefix'),
    'middleware' => [config('eloquent-stalker.middleware'), EnsureValidEnvironment::class],
], function () {

    /**
     * Eloquent Stalker Routes
     */

    Route::get('', [EloquentStalkerController::class, 'index'])->name(config('eloquent-stalker.prefix') . '.index');

});
