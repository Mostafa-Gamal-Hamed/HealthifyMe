<?php

namespace Database\Seeders;

use App\Models\HealthyRecipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 50; $i++) {
            HealthyRecipe::create([
                'title'       => 'Recipe ' . $i,
                'description' => $i . 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maxime necessitatibus quasi nam doloremque nobis tenetur optio, sint impedit, nihil perferendis perspiciatis qui alias error culpa animi velit. Delectus molestiae consequuntur dolor sunt! Corrupti nemo eius officia quia porro, culpa aliquid expedita nostrum architecto ratione saepe deserunt ad nulla et explicabo magnam voluptate odit minima inventore cumque laudantium amet reprehenderit! Nulla, quis inventore veritatis sunt eaque excepturi vel itaque. Unde esse blanditiis saepe est quod dignissimos at perferendis nihil? Inventore, beatae ut quidem ipsam dignissimos dolorum perferendis doloribus cumque minima fugiat explicabo veritatis numquam repudiandae? Amet debitis minima totam? Unde, laudantium.',
                'calories'    => $i . rand(500,5000),
                'images'      => null,
                'video'       => null,
                'user_id'     => rand(2,4),
            ]);
        }
    }
}

