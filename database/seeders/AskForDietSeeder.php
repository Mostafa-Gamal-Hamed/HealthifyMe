<?php

namespace Database\Seeders;

use App\Models\AskForDiet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AskForDietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ask = ['ask', 'change'];
        for ($i=0; $i < 100; $i++) {
            AskForDiet::create([
                'ask'     => $ask[array_rand($ask)],
                'user_id' => rand(5,100),
                'accept'  => rand(0,1),
            ]);
        }
    }
}
