<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class CreateChannelMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/channels/post.json';
    }

    public function method(): string
    {
        return 'createChannel';
    }
}
