<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * No package providers here - we register the test provider
     * manually per test, so we can set config() beforehand.
     */
    protected function getPackageProviders($app): array
    {
        return [];
    }
}
