<?php

namespace OhSeeSoftware\LaravelVeneer\Tests\Providers\Cronofy;

use OhSeeSoftware\LaravelVeneer\Providers\Cronofy\CronofyMock;
use OhSeeSoftware\LaravelVeneer\Tests\TestCase;

class CronofyMockTest extends TestCase
{
    /** @test */
    public function itReturnsMockedClass()
    {
        $this->assertEquals(\Cronofy\Cronofy::class, (new CronofyMock())->mockedClass());
    }
}
