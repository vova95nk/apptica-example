<?php

namespace Database\Seeders;

use App\Enums\CarCategories;
use App\Enums\DriverPositions;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\DriverPosition;
use App\Models\PositionCar;
use Illuminate\Database\Seeder;

class PositionCarsSeeder extends Seeder
{
    public function run(): void
    {
        $config = [
            CarCategories::Economy->value => DriverPositions::Economy->value,
            CarCategories::Comfort->value => DriverPositions::Comfort->value,
            CarCategories::Business->value => DriverPositions::Business->value,
        ];

        foreach ($config as $category => $position) {
            $category = CarCategory::query()->where('category_name', $category)->first();
            $position = DriverPosition::query()->where('position_name', $position)->first();


            PositionCar::firstOrCreate([
                'position_id' => $position->getKey(),
                'category_id' => $category->getKey(),
            ]);
        }
    }
}
