<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=0; $i < 100; $i++) {
            Food::create([
                'name' => 'Food ' . $i,
                'image' => 'foods/food.jpeg',
                'category_id' => rand(1, 5),
                'calories' => $i . rand(0.5, 1.5),
                'protein' => $i . rand(0.5, 1.5),
                'carbs' => $i . rand(0.5, 1.5),
                'fats' =>  $i . rand(0.5, 1.5),
                'vitamins' => chr(rand(65, 90)) . $i,
                'fiber' =>  $i . rand(0.5, 1.5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
