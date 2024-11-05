<?php

namespace CArena\EloquentStalker\Http\Controllers;

use CArena\EloquentStalker\ModelSchema;
use Illuminate\Http\Request;

class EloquentStalkerController
{
    public function index(Request $request)
    {
        $modelSchema = new ModelSchema;
        $models = $modelSchema->getModels();
        $relationships = $modelSchema->getRelationships();
        $selectedModel = $request->query('selectedModel');

        return view('eloquent-stalker::eloquent-stalker', ['selectedModel' => $selectedModel, 'models' => $models, 'relationships' => $relationships]);
    }
}
