<?php

namespace OhSeeSoftware\LaravelVeneer\Traits;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Mockery\MockInterface;
use OhSeeSoftware\LaravelVeneer\Providers\MockProvider;

/**
 * @mixin InteractsWithContainer
 */
trait VeneerMocks
{
    protected function veneer(MockProvider $provider): MockInterface
    {
        return $provider->setApplication($this->app)->mock();
    }
}
