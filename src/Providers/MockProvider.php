<?php

namespace OhSeeSoftware\LaravelVeneer\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Mockery\MockInterface;

abstract class MockProvider
{
    use InteractsWithContainer;

    abstract public function mockedClass(): string;

    protected ?Application $app;

    protected array $mocks = [];

    public static function make(): self
    {
        return new static();
    }

    public function setApplication(Application $app): self
    {
        $this->app = $app;

        return $this;
    }

    public function add(callable $callback): self
    {
        $this->mocks[] = $callback;

        return $this;
    }

    public function mock(): MockInterface
    {
        return $this->partialMock($this->mockedClass(), function (MockInterface $mock) {
            foreach ($this->mocks as $mockCallable) {
                if (!is_callable($mockCallable)) {
                    throw new \InvalidArgumentException('Mock must be callable');
                }

                call_user_func($mockCallable, $mock);
            }
        });
    }
}
