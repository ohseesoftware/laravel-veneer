<?php

namespace OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Profiles;

use OhSeeSoftware\LaravelVeneer\Providers\MockedMethod;

class RevokeProfileMock extends MockedMethod
{
    public function method(): string
    {
        return 'revokeProfile';
    }
}
