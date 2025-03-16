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
                'description' => 'Special Diet Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere qui asperiores obcaecati ea, harum quam. Quae, autem. Repudiandae libero ipsum numquam quisquam, neque, culpa debitis facilis laboriosam dicta earum quaerat nulla, praesentium cumque eius odio minus quae doloribus eligendi veritatis nisi! Voluptate, rem quibusdam consequuntur non nobis incidunt iure veritatis? ',
                'calories'    => rand(100, 1000),
                'workouts'    => rand(100, 1000),
                'images'      => json_encode(['diets/Diet.jpg']),
                'user_id'     => rand(35,90),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
