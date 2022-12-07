<?php

namespace Tests\Feature;

use Tests\TestCase;

class TripTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTripDatabase()
    {
        $this->assertDatabaseCount('trips', 5);
        $this->assertDatabaseHas('trips', ['id' => 1]);
        $this->assertDatabaseHas('trips', ['id' => 3]);
    }
}
