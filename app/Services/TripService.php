<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\TripRequest;
use App\Repositories\TripRepository;
use Illuminate\Support\Collection;

class TripService
{
    public function __construct(private TripRepository $tripRepository)
    {

    }

    public function addTrip(TripRequest $tripRequest): void
    {
        $tripRequest->validated();

        $this->tripRepository->insertModel($tripRequest->all());
    }

    public function getAllTrips(): Collection
    {
        return $this->tripRepository->fetchAll();
    }
}
