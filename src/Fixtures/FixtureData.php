<?php

namespace OhSeeSoftware\LaravelVeneer\Fixtures;

class FixtureData
{
    public static function load(string $path): array
    {
        $fixture = file_get_contents(realpath(__DIR__.'/../../fixtures/'.$path));

        return json_decode($fixture, true);
    }
}
