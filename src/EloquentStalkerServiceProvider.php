<?php

namespace CArena\EloquentStalker;

use CArena\EloquentStalker\Commands\EloquentStalkerCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasAssets()
            ->hasCommand(EloquentStalkerCommand::class)
            ->hasInstallCommand(function (InstallCommand $installCommand) {
                $installCommand
                    ->publishConfigFile()
                    ->publishAssets();
            });
    }
}
