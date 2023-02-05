<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CarCategories;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarManufacture;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;

class CarsSeeder extends Seeder
{
    protected array $carsData = [
        'Kia' => [
            'Rio' => [
                'class' => 'economy'
            ],
            'Optima' => [
                'class' => 'comfort'
            ],
        ],
        'BMW' => [
            '5-series' => [
                'class' => 'comfort'
            ],
            '7-series' => [
                'class' => 'business'
            ],
        ],
        'Mercedes-Benz' => [
            'E-class'=> [
                'class' => 'business'
            ],
            'S-class' => [
                'class' => 'business'
            ],
        ],
    ];

    public function run(): void
    {
        DB::beginTransaction();

        try {
            $this->seedCarManufactures();
            $this->seedCarCategories();
            $this->seedCarModels();
            $this->seedCars();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    private function seedCars(): void
    {
        CarManufacture::query()->chunkById(1000, function (Collection $chunckedManufactures) {
            $chunckedManufactures->each(function (CarManufacture $manufacture) {
                $models = $manufacture->models()->get();

                $models->each(function (CarModel $model) use ($manufacture) {
                    $categoryName = $this->carsData[$manufacture->name][$model->model_name]['class'];
                    $category = CarCategory::query()->where('category_name', $categoryName)->first();

                    if ($category) {
                        Car::firstOrCreate([
                            'manufacture_id' => $manufacture->getKey(),
                            'model_id' => $model->getKey(),
                            'category_id' => $category->getKey(),
                        ]);
                    }
                });
            });
        });
    }

    private function seedCarCategories(): void
    {
        foreach (CarCategories::cases() as $carCategory) {
            CarCategory::firstOrCreate([
                'category_name' => $carCategory->value,
            ]);
        }
    }

    private function seedCarModels(): void
    {
        CarModel::unsetEventDispatcher();

        CarManufacture::query()->chunkById(1000, function (Collection $chunckedData) {
            $chunckedData->each(function (CarManufacture $manufacture) {
                foreach ($this->carsData[$manufacture->name] as $model => $attributes) {
                    CarModel::firstOrCreate([
                        'manufacture_id' => $manufacture->getKey(),
                        'model_name' => $model,
                    ]);
                }
            });
        });
    }

    private function seedCarManufactures(): void
    {
        foreach ($this->carsData as $manufacture => $model) {
            CarManufacture::firstOrCreate([
                'name' => $manufacture,
            ]);
        }
    }
}
