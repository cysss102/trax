<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Car;

class CarRepository extends AbstractApiRepository
{
    public function __construct(private Car $car)
    {
        parent::__construct($this->car);
    }
}
