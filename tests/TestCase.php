<?php

namespace CodebarAg\Miro\Tests;

use CodebarAg\Miro\MiroServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MiroServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('miro.access_token', 'test-token');
    }
}
