<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiBadRequestException;
use App\Http\Requests\TripRequest;
use App\Repositories\TripRepository;
use Exception;
use Illuminate\Support\Collection;

class TripService
{
    public function __construct(private TripRepository $tripRepository)
    {

    }

    public function addTrip(TripRequest $tripRequest): void
    {
        try {
            $tripRequest->validated();

            $this->tripRepository->insertModel($tripRequest->all());
        } catch (Exception $exception) {
            throw new ApiBadRequestException($exception->getMessage());
        }
    }

    public function getAllTrips(): Collection
    {
        return $this->tripRepository->fetchAll();
    }
}
