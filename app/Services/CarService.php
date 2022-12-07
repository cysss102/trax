<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiBadRequestException;
use App\Exceptions\DataNotFoundException;
use App\Http\Requests\CarRequest;
use App\Repositories\CarRepository;
use App\Repositories\TripRepository;
use Exception;
use Illuminate\Support\Collection;

class CarService
{
    public function __construct(private CarRepository $carRepository, private TripRepository $tripRepository)
    {
    }

    public function addCar(CarRequest $carRequest): void
    {
        try {
            $carRequest->validated();

            $this->carRepository->insertModel($carRequest->all());
        } catch (Exception $exception) {
            throw new ApiBadRequestException($exception->getMessage());
        }
    }

    public function deleteModel(int $id): void
    {
        $this->carRepository->deleteModelById($id);
    }

    public function getAllCars(): Collection
    {
        return $this->carRepository->fetchAll();
    }

    public function getCarById(int $id): array
    {
        $carData = $this->carRepository->fetchModelById($id);

        if (null === $carData) {
            throw new DataNotFoundException();
        }

        $tripData = $this->tripRepository->fetchTotalMilesAndTripsByCarId($id);

        return array_merge($carData->toArray(), $tripData->toArray());
    }
}
