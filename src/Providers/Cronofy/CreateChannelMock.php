<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class CreateChannelMock extends MockedMethod
{
    public function fixturePath(): string
    {
        return 'cronofy/responses/createChannel.json';
    }

    public function method(): string
    {
        return 'createChannel';
    }
}
