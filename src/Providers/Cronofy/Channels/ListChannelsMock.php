<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class ListChannelsMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/channels/index.json';
    }

    public function method(): string
    {
        return 'listChannels';
    }
}
