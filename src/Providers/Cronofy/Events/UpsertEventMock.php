<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Events;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class UpsertEventMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/calendars/:id/events/post.json';
    }

    public function method(): string
    {
        return 'upsertEvent';
    }
}
