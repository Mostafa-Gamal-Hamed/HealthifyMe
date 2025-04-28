<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            // DietInfoSeeder::class,
            BlogSeeder::class,
            CategorySeeder::class,
            // FoodSeeder::class,
            DietSeeder::class,
            // SpecialDietSeeder::class,
            // ContactSeeder::class,
            // AskForDietSeeder::class,
            RecipeCategorySeeder::class,
            // RecipeSeeder::class
        ]);
    }
}
