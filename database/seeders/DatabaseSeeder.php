<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CarsSeeder::class);
        $this->call(DriverPositionsSeeder::class);
        $this->call(PositionCarsSeeder::class);
        $this->call(DriversSeeder::class);
    }
}
