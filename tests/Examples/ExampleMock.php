<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Examples;

use OhSeeSoftware\LaravelVeneer\Providers\MockProvider;

class ExampleMock extends MockProvider
{
    public function mockedClass(): string
    {
        return ExampleService::class;
    }
}
