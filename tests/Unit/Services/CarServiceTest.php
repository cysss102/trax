<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Exceptions\ApiBadRequestException;
use App\Exceptions\DataNotFoundException;
use App\Http\Requests\CarRequest;
use App\Repositories\CarRepository;
use App\Repositories\TripRepository;
use App\Services\CarService;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\Fixtures\ExampleDataFxitures;

class CarServiceTest extends TestCase
{
    use ExampleDataFxitures;

    private bool $processed = false;

    public function setProcessed(): void
    {
        $this->processed = true;
    }

    public function testAddCar(): void
    {
        $exampleRequestData = $this->exampleCarRequestData();

        $tripMock = $this->createMock(TripRepository::class);
        $requestMock = $this->createMock(CarRequest::class);
        $requestMock
            ->expects($this->once())
            ->method('validated');
        $requestMock
            ->expects($this->once())
            ->method('all')
            ->willReturn($exampleRequestData);
        $repoMock = $this->createMock(CarRepository::class);
        $repoMock
            ->expects($this->once())
            ->method('insertModel')
            ->with($exampleRequestData)
            ->willReturnCallback(
                function () {
                    $this->setProcessed();
                }
            );

        $service = new CarService($repoMock, $tripMock);
        $service->addCar($requestMock);

        $this->assertTrue($this->processed);
    }

    public function testAddCarThrowException(): void
    {
        $tripRepoMock = $this->createMock(TripRepository::class);
        $requestMock = $this->createMock(CarRequest::class);
        $requestMock
            ->expects($this->once())
            ->method('validated')
            ->willThrowException(new \Exception());
        $carRepoMock = $this->createMock(CarRepository::class);

        $service = new CarService($carRepoMock, $tripRepoMock);

        $this->expectException(ApiBadRequestException::class);

        $service->addCar($requestMock);
    }

    public function testDeleteCar(): void
    {
        $exampleId = $this->exampleId();
        $tripRepoMock = $this->createMock(TripRepository::class);
        $carRepoMock = $this->createMock(CarRepository::class);
        $carRepoMock
            ->expects($this->once())
            ->method('deleteModelById')
            ->with($exampleId)
            ->willReturnCallback(
                function () {
                    $this->setProcessed();
                }
            );

        $service = new CarService($carRepoMock, $tripRepoMock);

        $service->deleteModel($exampleId);

        $this->assertTrue($this->processed);
    }

    public function testGetAllCars(): void
    {
        $collection = $this->exampleCarsCollection();
        $tripRepoMock = $this->createMock(TripRepository::class);
        $carRepoMock = $this->createMock(CarRepository::class);
        $carRepoMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($collection);

        $service = new CarService($carRepoMock, $tripRepoMock);

        $result = $service->getAllCars();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($collection, $result);
        $this->assertSame($collection->toArray(), $result->toArray());
    }

    public function getCarById(): void
    {
        $exampleId = $this->exampleId();
        $carCollection = $this->exampleCarsCollection(true);
        $tripCollection = $this->exampleDataForTotalMilesAndTrips();

        $expectedResult = array_merge($carCollection->toArray(), $tripCollection->toArray());

        $tripRepoMock = $this->createMock(TripRepository::class);
        $tripRepoMock
            ->expects($this->once())
            ->method('fetchTotalMilesAndTripsByCarId')
            ->willReturn($tripCollection);
        $carRepoMock = $this->createMock(CarRepository::class);
        $carRepoMock
            ->expects($this->once())
            ->method('fetchModelById')
            ->with($exampleId)
            ->willReturn($carCollection);

        $service = new CarService($carRepoMock, $tripRepoMock);
        $result = $service->getCarById($exampleId);

        $this->assertIsArray($result);
        $this->assertSame($expectedResult, $result);
    }

    public function getCarByIdThrowException(): void
    {
        $exampleId = $this->exampleId();

        $tripRepoMock = $this->createMock(TripRepository::class);
        $carRepoMock = $this->createMock(CarRepository::class);
        $carRepoMock
            ->expects($this->once())
            ->method('fetchModelById')
            ->with($exampleId)
            ->willReturn(null);

        $service = new CarService($carRepoMock, $tripRepoMock);

        $this->expectException(DataNotFoundException::class);

        $service->getCarById($exampleId);
    }

}
