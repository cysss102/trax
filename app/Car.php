<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'year',
        'make',
        'model',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
