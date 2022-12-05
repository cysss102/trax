<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ApiRepositoryInterface
{
    public function insertModel(array $params);

    public function deleteModelById(int $id): void;

    public function fetchAll(): Collection;

    public function fetchModelById(int $id): ?Model;
}
