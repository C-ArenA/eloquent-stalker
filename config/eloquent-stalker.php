<?php

// config for CArena/EloquentStalker
return [
    'models_path' => app_path('Models'),
    'prefix' => 'eloquent-stalker',
    'middleware' => 'web',
    'max_env' => 'local' // I strongly sugges that this should be local always. However, you can change it to testing or production
];
