<?php

use CodebarAg\Miro\Tests\TestCase;
use Saloon\Laravel\Saloon;

uses(TestCase::class)
    ->afterEach(function () {
        Saloon::fake([]);
    })
    ->in(__DIR__);

/**
 * Helper function to check if fixtures should be reset/regenerated.
 * Set RESET_FIXTURES=true in phpunit.xml to regenerate fixtures from live API.
 * Defaults to false (use existing fixtures).
 */
function shouldResetFixtures(): bool
{
    return filter_var(getenv('RESET_FIXTURES') ?: false, FILTER_VALIDATE_BOOLEAN);
}
