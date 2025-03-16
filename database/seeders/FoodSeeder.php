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
                'category_id' => rand(1, 9),
                'calories' => $i,
                'protein' => $i,
                'carbs' => $i,
                'fats' =>  $i,
                'vitamins' => chr(rand(65, 90)) . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
