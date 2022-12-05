<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date',
        'miles',
        'total',
        'car_id',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
