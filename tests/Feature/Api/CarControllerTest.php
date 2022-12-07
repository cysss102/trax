<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;

class CarControllerTest extends TestCase
{
    public function testIndexGetAllCars(): void
    {
        $this->actingUser();

        $response = $this->get('/api/cars');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'year',
                    'make',
                    'model',
                ],
            ],
        ]);
    }

    public function testShowGetCar(): void
    {
        $this->actingUser();

        $response = $this->get('/api/car/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'year',
                'make',
                'model',
                'trip_miles',
                'trip_count',
            ],
        ]);
    }

    public function testShowThrowCarNotFound(): void
    {
        $this->actingUser();

        $response = $this->get('/api/car/0');
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
        $response->assertExactJson(['message' => 'Resource not found']);
    }

    public function testStoreAddNewCar(): void
    {
        $this->actingUser();

        $response = $this->post('/api/cars', [
            'year' => 1231,
            'make' => 'test',
            'model' => 'test',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message']);
        $response->assertExactJson(['message' => 'Added']);
    }

    public function testStoreTryAddCarByInvalidData(): void
    {
        $this->actingUser();

        $response = $this->post('/api/cars', [
            'year' => 'badyear',
            'make' => 'test',
            'model' => 'test',
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['message']);
        $response->assertExactJson(['message' => 'Bad request']);
    }

    public function testDestroyCar(): void
    {
        $this->actingUser();

        $response = $this->delete('/api/car/1');

        $response->assertStatus(204);
    }

    public function testDestroyThrowCarNotFound(): void
    {
        $this->actingUser();

        $response = $this->delete('/api/car/0');

        $response->assertStatus(404);
    }
}
