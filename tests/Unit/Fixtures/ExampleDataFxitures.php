<?php

declare(strict_types=1);

namespace Tests\Unit\Fixtures;


use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

trait ExampleDataFxitures
{
    public function exampleCarRequestData(): array
    {
        return [
            'id' => 123,
            'year' => 2022,
            'model' => 'test',
            'make' => 'test',
        ];
    }

    public function exampleTripRequestData(): array
    {
        return [
          'car_id' => 2,
          'date' => now()->format('Y-m-d'),
          'miles' => 23.2
        ];
    }

    public function exampleId(): int
    {
        return 1;
    }

    public function exampleDataForTotalMilesAndTrips(): Collection
    {
        return collect([
            'trip_miles' => 50.2,
            'trip_count' => 2,
        ]);
    }

    public function exampleTripsCollection(): Collection
    {
        return collect($this->trips());
    }

    public function exampleCarsCollection(bool $onlyOneElement = false): Collection
    {
        if (true === $onlyOneElement) {
            return collect($this->cars()[0]);
        }
        return collect();
    }

    private function cars(): array
    {
        return [
            [
                'make' => 'Land Rover',
                'model' => 'Range Roverssss Sport',
                'year' => 2017,
            ],
            [
                'make' => 'Ford',
                'model' => 'F150',
                'year' => 2014,
            ],
            [
                'make' => 'Chevy',
                'model' => 'Tahoe',
                'year' => 2015,
            ],
            [
                'make' => 'Aston Martin',
                'model' => 'Vanquish',
                'year' => 2018,
            ],
        ];
    }

    private function trips(): array
    {
        return [
            [
                'id' => 1,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 11.3,
                'total' => 45.3,
                'car_id' => 1
            ],
            [
                'id' => 2,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 12.0,
                'total' => 34.1,
                'car_id' => 4
            ],
            [
                'id' => 3,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 6.8,
                'total' => 22.1,
                'car_id' => 1
            ],
            [
                'date' => Carbon::now()->toDateTime(),
                'miles' => 5,
                'total' => 15.3,
                'car_id' => 2
            ],
            [
                'date' => Carbon::now()->toDateTime(),
                'miles' => 10.3,
                'total' => 10.3,
                'car_id' => 3
            ],
        ];
    }
}
