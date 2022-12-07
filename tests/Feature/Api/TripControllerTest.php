<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;

class TripControllerTest extends TestCase
{
    public function testIndexGetAllTrips(): void
    {
        $this->actingUser();

        $response = $this->get('/api/trips');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'date',
                    'miles',
                    'total',
                    'car' => [
                        'id',
                        'year',
                        'make',
                        'model',
                    ],
                ],
            ],
        ]);
    }

    public function testStoreTrip(): void
    {
        $this->actingUser();

        $response = $this->post('/api/trips', [
            'car_id' => 1,
            'date' =>  '2022-12-22',
            'miles' => 24.1,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => 'Added']);
    }

    public function testStoreTripTryPostInvalidData(): void
    {
        $this->actingUser();

        $response = $this->post('/api/trips', [
            'car_id' => 0,
            'date' =>  '2022-12-22',
            'miles' => 24.1,
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => 'Bad request']);
    }
}
