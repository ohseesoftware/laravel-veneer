<?php

namespace OhSeeSoftware\LaravelVeneer\Providers;

use Illuminate\Support\Arr;
use Mockery\MockInterface;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;

abstract class MockedMethod
{
    abstract public function method(): string;

    protected $withArgs;
    protected $result;
    protected array $merges = [];
    protected int $times = 1;

    public function fixturePath(): ?string
    {
        return null;
    }

    public static function make(): self
    {
        return new static();
    }

    public function __invoke(MockInterface $mock): void
    {
        $expected = $mock->shouldReceive($this->method());

        if ($this->withArgs) {
            $expected->withArgs($this->withArgs);
        }

        $expected->times($this->times)->andReturn($this->result());
    }

    /**
     * The result returned from the mocked method.
     */
    public function result()
    {
        if ($this->result) {
            return $this->result;
        }

        $fixturePath = $this->fixturePath();
        if (!$fixturePath) {
            return;
        }

        $result = FixtureData::load($fixturePath);

        foreach ($this->merges as $merge) {
            Arr::set($result, $merge[0], $merge[1]);
        }

        return $result;
    }

    /**
     * Define a custom result to be returned.
     */
    public function return($result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Define a (deep) key/pair to merge into the
     * result returned from the fixture data.
     *
     * This is not called when the `return` method is used.
     */
    public function merge(string $path, $value): self
    {
        $this->merges[] = [$path, $value];

        return $this;
    }

    /**
     * Define how many times you expect the method to be called.
     */
    public function times(int $times): self
    {
        $this->times = $times;

        return $this;
    }

    /**
     * Define what arguments are expected to be passed
     * into the mocked method.
     */
    public function with(...$args): self
    {
        $this->withArgs = $args;

        return $this;
    }
}
