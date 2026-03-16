<?php

namespace CodebarAg\Miro\Tests;

use CodebarAg\Miro\MiroServiceProvider;
use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        if (file_exists(__DIR__.'/../.env.testing')) {
            Dotenv::createMutable(__DIR__.'/..', '.env.testing')->safeLoad();
        }

        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MiroServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('miro.access_token', env('MIRO_ACCESS_TOKEN', 'test-token'));
    }
}
