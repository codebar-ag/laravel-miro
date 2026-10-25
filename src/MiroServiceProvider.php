<?php

namespace CodebarAg\Miro;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MiroServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-miro')
            ->hasConfigFile('miro');
    }

    public function registeringPackage(): void
    {
        $this->app->bind(MiroConnector::class, function () {
            return new MiroConnector();
        });
    }
}
