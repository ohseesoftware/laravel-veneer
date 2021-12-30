<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy;

use OhSeeSoftware\LaravelVeneer\Providers\MockProvider;

class CronofyMock extends MockProvider
{
    public function mockedClass(): string
    {
        return \Cronofy\Cronofy::class;
    }
}
