<?php

namespace CArena\EloquentStalker\Http\Controllers;

use CArena\EloquentStalker\EloquentStalker;
use Illuminate\Http\Request;

class EloquentStalkerController
{
    public function index(Request $request)
    {
        $stalker = new EloquentStalker;
        $models = $stalker->getModels();
        $relationships = $stalker->getRelationships();
        $selectedModel = $request->query('selectedModel');

        return view('eloquent-stalker::eloquent-stalker', ['selectedModel' => $selectedModel, 'models' => $models, 'relationships' => $relationships]);
    }
}
