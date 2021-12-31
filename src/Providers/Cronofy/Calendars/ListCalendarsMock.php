<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Calendars;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class ListCalendarsMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/calendars/index.json';
    }

    public function method(): string
    {
        return 'listCalendars';
    }
}
