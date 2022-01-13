<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Events;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class DeleteEventMock extends MockedMethod
{
    public function method(): string
    {
        return 'deleteEvent';
    }
}
