<?php

namespace CArena\EloquentStalker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CArena\EloquentStalker\Commands\EloquentStalkerCommand;

class EloquentStalkerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('eloquent-stalker')
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasViews()
            ->hasMigration('create_eloquent_stalker_table')
            ->hasCommand(EloquentStalkerCommand::class);
    }
}
