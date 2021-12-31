<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy\Calendars;

use Illuminate\Support\Arr;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;
use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Calendars\ListCalendarsMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class ListCalendarsMockTest extends TestCase
{
    use VeneerMocks;

    private ListCalendarsMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new ListCalendarsMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $fixture = FixtureData::load($this->mock->fixturePath());

        $this->assertEquals('cal_000000', Arr::get($fixture, 'calendars.0.calendar_id'));
    }
}
