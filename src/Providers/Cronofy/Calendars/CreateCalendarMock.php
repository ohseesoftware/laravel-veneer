<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Calendars;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class CreateCalendarMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/calendars/post.json';
    }

    public function method(): string
    {
        return 'createCalendar';
    }
}
