<?php

namespace CodebarAg\Miro\Tests\Live;

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\MiroServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;

class TestCase extends Orchestra
{
    private ?string $resolvedTeamId = null;

    protected function setUp(): void
    {
        parent::setUp();

        MockClient::destroyGlobal();
        Config::allowStrayRequests();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MiroServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $token = $this->resolveToken();

        $app['config']->set('miro.access_token', $token);
    }

    public function teamId(): ?string
    {
        if ($this->resolvedTeamId !== null) {
            return $this->resolvedTeamId;
        }

        $teamId = $this->resolveEnvValue('MIRO_TEAM_ID');
        if ($teamId !== '') {
            $this->resolvedTeamId = $teamId;

            return $this->resolvedTeamId;
        }

        $boards = app(MiroConnector::class)->getBoards()->dto();
        if (is_array($boards) && count($boards) > 0 && $boards[0]->teamId !== null) {
            $this->resolvedTeamId = $boards[0]->teamId;

            return $this->resolvedTeamId;
        }

        return null;
    }

    private function resolveToken(): string
    {
        return $this->resolveEnvValue('MIRO_ACCESS_TOKEN');
    }

    private function resolveEnvValue(string $key): string
    {
        $value = env($key);
        if (is_string($value) && $value !== '') {
            return $value;
        }

        $envFile = realpath(__DIR__.'/../../.env.testing');
        if ($envFile && is_readable($envFile)) {
            foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#') || ! str_contains($line, '=')) {
                    continue;
                }
                [$envKey, $envValue] = explode('=', $line, 2);
                if (trim($envKey) === $key) {
                    return trim($envValue, " \t\n\r\0\x0B\"'");
                }
            }
        }

        return '';
    }
}
