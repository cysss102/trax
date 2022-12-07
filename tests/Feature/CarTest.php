<?php

namespace Tests\Feature;

use App\Car;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCarDatabase()
    {
        $this->assertDatabaseCount('cars', 4);
        $this->assertDatabaseHas('cars', ['id' => 1]);
        $this->assertDatabaseHas('cars', ['id' => 3]);
    }
}
