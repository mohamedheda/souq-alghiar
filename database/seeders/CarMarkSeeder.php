<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\Mark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = public_path('json/car_makes_matched.json');
        if (!file_exists($jsonPath)) {
            throw new \Exception("JSON file not found at " . $jsonPath);
        }

        $cars = json_decode(file_get_contents($jsonPath), true);
        if (!$cars) {
            throw new \Exception("Invalid JSON format in cars.json");
        }

        foreach ($cars as $car) {
            $mark = Mark::create([
                'name_en' => $car['name_en'],
                'name_ar' => $car['name_ar'],
                'logo' => $car['logo'],
            ]);

            foreach ($car['models'] as $model) {
                CarModel::create([
                    'mark_id' => $mark->id,
                    'name_en' => $model['name_en'],
                    'name_ar' => $model['name_ar'],
                ]);
            }
        }
    }
}
