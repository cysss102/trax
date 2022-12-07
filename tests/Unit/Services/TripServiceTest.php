<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Exceptions\ApiBadRequestException;
use App\Http\Requests\TripRequest;
use App\Repositories\TripRepository;
use App\Services\TripService;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\Fixtures\ExampleDataFxitures;

class TripServiceTest extends TestCase
{
    use ExampleDataFxitures;

    private bool $processed = false;

    public function setProcessed(): void
    {
        $this->processed = true;
    }

    public function testAddTrip(): void
    {
        $exampleRequest = $this->exampleTripRequestData();

        $requestMock = $this->createMock(TripRequest::class);
        $requestMock
            ->expects($this->once())
            ->method('validated');
        $requestMock
            ->expects($this->once())
            ->method('all')
            ->willReturn($exampleRequest);
        $tripRepoMock = $this->createMock(TripRepository::class);
        $tripRepoMock
            ->expects($this->once())
            ->method('insertModel')
            ->with($exampleRequest)
            ->willReturnCallback(
                function () {
                    $this->setProcessed();
                }
            );

        $service = new TripService($tripRepoMock);
        $service->addTrip($requestMock);

        $this->assertTrue($this->processed);
    }

    public function testAddTripThrowException(): void
    {
        $requestMock = $this->createMock(TripRequest::class);
        $requestMock
            ->expects($this->once())
            ->method('validated')
            ->willThrowException(new \Exception());
        $tripRepoMock = $this->createMock(TripRepository::class);

        $service = new TripService($tripRepoMock);

        $this->expectException(ApiBadRequestException::class);

        $service->addTrip($requestMock);
    }

    public function testGetAllTrips(): void
    {
        $collection = $this->exampleTripsCollection();
        $tripRepoMock = $this->createMock(TripRepository::class);
        $tripRepoMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($collection);

        $service = new TripService($tripRepoMock);

        $result = $service->getAllTrips();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($collection, $result);
        $this->assertSame($collection->toArray(), $result->toArray());
    }
}
