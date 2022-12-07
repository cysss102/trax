<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\TripRepository;
use App\Trip;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\Fixtures\ExampleDataFxitures;

class TripRepositoryTest extends TestCase
{
    use ExampleDataFxitures;

    public function testFetchAll(): void
    {
        $expectedCollection = $this->exampleTripsCollection();

        $queryBuilderMock = $this->createMock(\Illuminate\Database\Eloquent\Builder::class);
        $queryBuilderMock
            ->expects($this->once())
            ->method('with')
            ->with($this->identicalTo('car'))
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('get')
            ->willReturn($expectedCollection);
        $mockModel = $this->createMock(Trip::class);
        $mockModel
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $repo = new TripRepository($mockModel);
        $result = $repo->fetchAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($expectedCollection, $result);
    }

    public function testFetchTotalMilesAndTripsByCarId(): void
    {
        $exampleId = $this->exampleId();
        $expectedCollection = $this->exampleDataForTotalMilesAndTrips();

        $queryBuilderMock = $this->createMock(Builder::class);
        $queryBuilderMock
            ->expects($this->once())
            ->method('selectRaw')
            ->with($this->identicalTo('SUM(total) as trip_miles, COUNT(id) as trip_count'))
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('where')
            ->with(
                $this->identicalTo('car_id'),
                $this->identicalTo('='),
                $exampleId
            )
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('first')
            ->willReturn($expectedCollection);
        $mockModel = $this->createMock(Trip::class);
        $mockModel
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $repo = new TripRepository($mockModel);
        $result = $repo->fetchTotalMilesAndTripsByCarId($exampleId);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($expectedCollection->all(), $result->all());
    }
}
