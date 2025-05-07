<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Cereals', 'Vegetable', 'Fruit', 'Dairy products', 'Meat', 'Fish'];
        $images = ['foods/2-cereals.jpg', 'foods/1-vegetable.jpg', 'foods/3-fruits.jpeg', 'foods/4-dairy.jpg', 'foods/5-meats.jpg', 'foods/6-fishs.jpg'];

        foreach ($categories as $index => $name) {
            Category::create([
                'name'  => $name,
                'image' => $images[$index],
            ]);
        }
    }
}
