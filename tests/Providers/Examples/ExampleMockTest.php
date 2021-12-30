<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Examples;

use OhSeeSoftware\LaravelVeneer\Tests\Examples\ExampleMock;
use OhSeeSoftware\LaravelVeneer\Tests\Examples\ExampleService;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;

class ExampleMockTest extends TestCase
{
    /** @test */
    public function itReturnsMockedClass()
    {
        $this->assertEquals(ExampleService::class, (new ExampleMock())->mockedClass());
    }
}
