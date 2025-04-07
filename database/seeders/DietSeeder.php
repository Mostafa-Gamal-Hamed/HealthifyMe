<?php

namespace Database\Seeders;

use App\Models\Diet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Diet::create([
                'name'        => 'Diet ' . $i,
                'description' => $i . 'Diet Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere qui asperiores obcaecati ea, harum quam. Quae, autem. Repudiandae libero ipsum numquam quisquam, neque, culpa debitis facilis laboriosam dicta earum quaerat nulla, praesentium cumque eius odio minus quae doloribus eligendi veritatis nisi! Voluptate, rem quibusdam consequuntur non nobis incidunt iure veritatis?',
                'calories'    => rand(100, 1000),
                'workouts'    => rand(100, 1000),
                'images'      => json_encode(['diets/Diet.jpg']),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
