<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy\Channels;

use Illuminate\Support\Arr;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;
use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Channels\ListChannelsMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class ListChannelsMockTest extends TestCase
{
    use VeneerMocks;

    private ListChannelsMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new ListChannelsMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $fixture = FixtureData::load($this->mock->fixturePath());

        $this->assertEquals('chn_0000000000', Arr::get($fixture, 'channels.0.channel_id'));
    }
}
