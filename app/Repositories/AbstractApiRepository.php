<?php

declare(strict_types=1);

namespace App\Repositories;

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
        $car = $this->model::find($id);

        $car->delete();
    }

    public function fetchAll(): Collection
    {
        return $this->model::all();
    }

    public function fetchModelById(int $id): ?Model
    {
        return $this->model::select()
            ->where('id', $id)
            ->first();
    }
}
