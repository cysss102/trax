<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('trips');

        $table->truncate();

        foreach ($this->data() as $car) {
            $table->insert($car);
        }
    }

    private function data(): array
    {
        return [
            [
                'id' => 1,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 11.3,
                'total' => 45.3,
                'car_id' => 1
            ],
            [
                'id' => 2,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 12.0,
                'total' => 34.1,
                'car_id' => 4
            ],
            [
                'id' => 3,
                'date' => Carbon::now()->toDateTime(),
                'miles' => 6.8,
                'total' => 22.1,
                'car_id' => 1
            ],
            [
                'date' => Carbon::now()->toDateTime(),
                'miles' => 5,
                'total' => 15.3,
                'car_id' => 2
            ],
            [
                'date' => Carbon::now()->toDateTime(),
                'miles' => 10.3,
                'total' => 10.3,
                'car_id' => 3
            ],
        ];
    }
}
