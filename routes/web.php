<?php

use CArena\EloquentStalker\Http\Controllers\EloquentStalkerController;
use Illuminate\Support\Facades\Route;

Route::get('eloquent-stalker', [EloquentStalkerController::class, 'index'])->name('eloquent-stalker.index');
