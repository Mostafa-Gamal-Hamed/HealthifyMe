<?php

namespace Database\Seeders;

use App\Models\RecipeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Breakfast','Lunch','Dinner','Snacks','Healthy Fast Food'];
        foreach ($categories as $category) {
            RecipeCategory::create(['name' => $category]);
        }
    }
}
