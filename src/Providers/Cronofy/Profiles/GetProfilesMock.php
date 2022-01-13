<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Profiles;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class GetProfilesMock extends MockedMethod
{
    public function fixturePath(): ?string
    {
        return 'cronofy/responses/v1/profiles/index.json';
    }

    public function method(): string
    {
        return 'getProfiles';
    }
}
