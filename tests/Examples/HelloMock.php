<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Examples;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class HelloMock extends MockedMethod
{
    public function fixturePath(): string
    {
        return 'examples/responses/hello.json';
    }

    public function method(): string
    {
        return 'hello';
    }
}
