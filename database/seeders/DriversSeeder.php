<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverPosition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DriversSeeder extends Seeder
{
    public function run(): void
    {
        Driver::factory()->count(10)->create();

        Driver::query()->chunkById(1000, function (Collection $chunckedDrivers) {
            $chunckedDrivers->each(function (Driver $driver) {
                $driver->position_id = DriverPosition::query()->inRandomOrder()->first()->getKey();
                $driver->saveQuietly();
            });
        });
    }
}
