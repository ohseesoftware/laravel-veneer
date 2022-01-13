<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Events;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class ReadEventsMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/events/index.json';
    }

    public function method(): string
    {
        return 'readEvents';
    }
}
