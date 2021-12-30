<?php

namespace OhSeeSoftware\LaravelVeneer\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setupDatabase()
    {
        // Create a schema here if you need one for testing
    }

    protected function getPackageProviders($app)
    {
        return [];
    }
}
