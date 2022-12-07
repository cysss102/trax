<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractApiRepository implements ApiRepositoryInterface
{
    public function __construct(private Model $model)
    {

    }

    public function insertModel(array $params)
    {
        $this->model->fill($params)->save();
    }

    public function deleteModelById(int $id): void
    {
        $car = $this->model->newQuery()->find($id);

        if (null === $car) {
            throw new DataNotFoundException();
        }

        $car->delete();
    }

    public function fetchAll(): Collection
    {
        return $this->model->newQuery()->select()->get();
    }

    public function fetchModelById(int $id): ?Model
    {
        return $this->model->newQuery()
            ->select()
            ->where('id', $id)
            ->first();
    }
}
