<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy\Channels;

use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels\CloseChannelMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class CloseChannelMockTest extends TestCase
{
    use VeneerMocks;

    private CloseChannelMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new CloseChannelMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $this->assertNull($this->mock->fixturePath());
    }
}
