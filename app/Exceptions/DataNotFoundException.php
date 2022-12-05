<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DataNotFoundException extends \Exception
{
    private const MESSAGE = 'Data not found!';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
