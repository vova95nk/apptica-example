<?php

namespace Database\Seeders;

use App\Enums\DriverPositions;
use App\Models\DriverPosition;
use Illuminate\Database\Seeder;

class DriverPositionsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (DriverPositions::cases() as $driverPosition) {
            DriverPosition::firstOrCreate([
                'position_name' => $driverPosition->value,
            ]);
        }
    }
}
