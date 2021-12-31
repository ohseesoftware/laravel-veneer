<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class CloseChannelMock extends MockedMethod
{
    public function method(): string
    {
        return 'closeChannel';
    }
}
