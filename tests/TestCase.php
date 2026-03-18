<?php

namespace CodebarAg\Miro\Tests;

use CodebarAg\Miro\MiroServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Config;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::preventStrayRequests();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MiroServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        if (is_dir(__DIR__.'/Fixtures/Saloon/') && count(scandir(__DIR__.'/Fixtures/Saloon')) > 0) {
            $app['config']->set('miro.access_token', 'fake-token');
        }
    }
}
