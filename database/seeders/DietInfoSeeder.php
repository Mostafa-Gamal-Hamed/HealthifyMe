<?php

namespace Database\Seeders;

use App\Models\DietInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DietInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gender   = ['male', 'female'];
        $activity = ['low', 'moderate', 'high', 'professional'];

        for ($i = 0; $i < 100; $i++) {
            DietInfo::create([
                'age'    => rand(15,60),
                'gender' => $gender[array_rand($gender)],
                'weight' => rand(70,200),
                'height' => rand(150,180),
                'activity_level'         => $activity[array_rand($gender)],
                'workout_hours_per_week' => rand(0,10),
                'bodyFat'    => rand(150,180),
                'bodyWater'  => rand(150,180),
                'diseases'   => $i . Str::random(20),
                'treatment'  => $i . Str::random(10),
                'user_id'    => rand(4,100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
