<?php

namespace Database\Seeders;

use App\Models\SpecialDiet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialDietSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=0; $i < 100; $i++) {
            SpecialDiet::create([
                'name'        => 'Special Diet ' . $i,
                'description' => $i . 'Special Diet Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere qui asperiores obcaecati ea, harum quam. Quae, autem. Repudiandae libero ipsum numquam quisquam, neque, culpa debitis facilis laboriosam dicta earum quaerat nulla, praesentium cumque eius odio minus quae doloribus eligendi veritatis nisi! Voluptate, rem quibusdam consequuntur non nobis incidunt iure veritatis? ',
                'calories'    => rand(100, 1000),
                'protein'     => rand(1, 10)/10,
                'carbs'       => rand(1, 10)/10,
                'fats'        => rand(1, 10)/10,
                'workouts'    => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod reprehenderit libero asperiores laborum eaque nobis? Explicabo obcaecati dolore unde corrupti modi repellendus distinctio! Necessitatibus, adipisci aliquam! Corrupti, ducimus, sapiente fugit ab minima ex earum quisquam mollitia laborum ut repudiandae in aliquid.",
                'images'      => 'diets/Diet.jpg',
                'user_id'     => rand(35,90),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
