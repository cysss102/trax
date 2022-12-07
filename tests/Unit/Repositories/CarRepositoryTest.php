<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Car;
use App\Exceptions\DataNotFoundException;
use App\Repositories\CarRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\Fixtures\ExampleDataFxitures;

class CarRepositoryTest extends TestCase
{
    use ExampleDataFxitures;

    private bool $processed = false;

    public function setProcessed(): void
    {
        $this->processed = true;
    }

    public function testInsertModel(): void
    {
        $exampleParams = $this->exampleCarRequestData();

        $modelMock = $this->createMock(Car::class);
        $modelMock
            ->expects($this->once())
            ->method('fill')
            ->with($exampleParams)
            ->willReturn($modelMock);
        $modelMock
            ->expects($this->once())
            ->method('save')
            ->willReturnCallback(
                function () {
                    $this->setProcessed();
                }
            );

        $repo = new CarRepository($modelMock);
        $repo->insertModel($exampleParams);

        $this->assertTrue($this->processed);
    }

    public function testDeleteModelById(): void
    {
        $exampleId = $this->exampleId();

        $expectedModelMock = $this->createMock(Car::class);
        $expectedModelMock
            ->expects($this->once())
            ->method('delete')
            ->willReturnCallback(
                function () {
                    $this->setProcessed();
                }
            );
        $queryBuilder = $this->createMock(\Illuminate\Database\Query\Builder::class);
        $queryBuilder
            ->expects($this->once())
            ->method('find')
            ->with($exampleId)
            ->willReturn($expectedModelMock);
        $modelMock = $this->createMock(Car::class);
        $modelMock
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilder);

        $repo = new CarRepository($modelMock);
        $repo->deleteModelById($exampleId);

        $this->assertTrue($this->processed);
    }

    public function testDeleteModelByIdThrowException(): void
    {
        $exampleId = $this->exampleId();

        $queryBuilder = $this->createMock(\Illuminate\Database\Query\Builder::class);
        $queryBuilder
            ->expects($this->once())
            ->method('find')
            ->with($exampleId)
            ->willReturn(null);
        $modelMock = $this->createMock(Car::class);
        $modelMock
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilder);

        $repo = new CarRepository($modelMock);

        $this->expectException(DataNotFoundException::class);

        $repo->deleteModelById($exampleId);
    }

    public function testFetchAll(): void
    {
        $expectedCollection = $this->exampleCarsCollection();

        $queryBuilderMock = $this->createMock(\Illuminate\Database\Query\Builder::class);
        $queryBuilderMock
            ->expects($this->once())
            ->method('select')
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('get')
            ->willReturn($expectedCollection);
        $modelMock = $this->createMock(Car::class);
        $modelMock
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $repo = new CarRepository($modelMock);
        $result = $repo->fetchAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame($expectedCollection->all(), $result->all());
    }

    public function testFetchModelById(): void
    {
        $exampleId = $this->exampleId();

        $queryBuilderMock = $this->createMock(\Illuminate\Database\Query\Builder::class);
        $queryBuilderMock
            ->expects($this->once())
            ->method('select')
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('where')
            ->with($this->identicalTo('id'), $exampleId)
            ->willReturn($queryBuilderMock);
        $queryBuilderMock
            ->expects($this->once())
            ->method('first')
            ->willReturn(new Car());
        $modelMock = $this->createMock(Car::class);
        $modelMock
            ->expects($this->once())
            ->method('newQuery')
            ->willReturn($queryBuilderMock);

        $repo = new CarRepository($modelMock);
        $result = $repo->fetchModelById($exampleId);

        $this->assertInstanceOf(Car::class, $result);
    }
}
