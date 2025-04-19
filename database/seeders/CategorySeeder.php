<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Cereals','Vegetable','Fruit','Dairy products','Meat','Fish'];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
