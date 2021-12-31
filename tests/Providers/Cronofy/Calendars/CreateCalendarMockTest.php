<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy\Calendars;

use Illuminate\Support\Arr;
use OhSeeSoftware\LaravelVeneer\Fixtures\FixtureData;
use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\Calendars\CreateCalendarMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;
use OhSeeSoftware\LaravelVeneer\Traits\VeneerMocks;

class CreateCalendarMockTest extends TestCase
{
    use VeneerMocks;

    private CreateCalendarMock $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = new CreateCalendarMock();
    }

    /** @test */
    public function itReturnsFixturePath()
    {
        $fixture = FixtureData::load($this->mock->fixturePath());

        $this->assertEquals('cal_000000', Arr::get($fixture, 'calendar.calendar_id'));
    }
}
