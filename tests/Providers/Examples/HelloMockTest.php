<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Examples;

use Illuminate\Support\Arr;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;
use OhSeeSoftware\LaravelVeneer\Tests\Examples\ExampleMock;
use OhSeeSoftware\LaravelVeneer\Tests\Examples\ExampleService;
use OhSeeSoftware\LaravelVeneer\Tests\Examples\HelloMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class HelloMockTest extends TestCase
{
    use VeneerMocks;

    private HelloMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new HelloMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $fixture = FixtureData::load($this->mock->fixturePath());

        $this->assertEquals('buzz', Arr::get($fixture, 'fizz'));
    }

    /** @test */
    public function itMocksHelloMethod()
    {
        // Given
        $this->veneer(
            ExampleMock::make()
                ->add(
                    HelloMock::make()->merge('fizz', 'buzz')
                )
        );

        // When
        $service = resolve(ExampleService::class);

        // Then
        $this->assertEquals([
            'fizz' => 'buzz',
        ], $service->hello());
    }

    /** @test */
    public function itMocksHelloMethodWithCustomReturnValue()
    {
        // Given
        $this->veneer(
            ExampleMock::make()
                ->add(
                    HelloMock::make()->return(['fizz' => 'bo'])
                )
        );

        // When
        $service = resolve(ExampleService::class);

        // Then
        $this->assertEquals([
            'fizz' => 'bo',
        ], $service->hello());
    }
}
