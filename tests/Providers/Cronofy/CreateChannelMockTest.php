<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy;

use Illuminate\Support\Arr;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;
use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\CreateChannelMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class CreateChannelMockTest extends TestCase
{
    use VeneerMocks;

    private CreateChannelMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new CreateChannelMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $fixture = FixtureData::load($this->mock->fixturePath());

        $this->assertEquals('chn_0000000000', Arr::get($fixture, 'channel.channel_id'));
    }
}
