<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Trip;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class TripRepository extends AbstractApiRepository
{
    public function __construct(private Trip $trip, private DatabaseManager $databaseManager)
    {
        parent::__construct($this->trip);
    }

    public function fetchAll(): Collection
    {
        return $this->trip::with('car')->get();
    }

    public function fetchTotalMilesAndTripsByCarId(int $carId): Collection
    {
        $result = $this->databaseManager->table($this->trip->getTable())
            ->select($this->databaseManager->raw('SUM(total) as trip_miles, COUNT(id) as trip_count'))
            ->where('car_id', '=', $carId)
            ->first();

        return collect($result);
    }
}
