<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('cars');

        $table->truncate();

        foreach ($this->data() as $car) {
            $table->insert($car);
        }
    }

    private function data(): array
    {
        return [
            [
                'make' => 'Land Rover',
                'model' => 'Range Roverssss Sport',
                'year' => 2017,
            ],
            [
                'make' => 'Ford',
                'model' => 'F150',
                'year' => 2014,
            ],
            [
                'make' => 'Chevy',
                'model' => 'Tahoe',
                'year' => 2015,
            ],
            [
                'make' => 'Aston Martin',
                'model' => 'Vanquish',
                'year' => 2018,
            ],
        ];
    }
}
