<?php

namespace Database\Seeders;

use App\Models\Diet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $name = [
            "Keto Diet", "Mediterranean Diet", "Intermittent Fasting",
            "Vegetarian Diet", "Paleo Diet",
            "DASH Diet (Dietary Approaches to Stop Hypertension)", "Low-Carb Diet"
        ];
        $description = [
            "Focuses on very low carbs, high fats, and moderate protein. The goal is to enter 'ketosis,' where the body burns fat for energy instead of carbs.",
            "Emphasizes vegetables, fruits, whole grains, olive oil, fish, and nuts. Reduces red meat and processed foods.",
            "Involves eating within a specific time window (e.g., 16:8 — fasting for 16 hours, eating within 8). It’s more about when you eat than what you eat.",
            "Excludes meat and sometimes other animal products. Focuses on plant-based foods such as vegetables, legumes, grains, and fruits.",
            "Inspired by what early humans might have eaten — includes lean meats, fish, fruits, vegetables, nuts, and seeds. Excludes grains, dairy, and processed foods.",
            "Designed to lower blood pressure. Emphasizes fruits, vegetables, whole grains, and low-fat dairy. Limits salt, sugar, and red meat.",
            "Reduces overall carbohydrate intake and increases protein and healthy fat consumption. Often used for weight loss or managing blood sugar."
        ];
        $kcl = [
            "1500-2000 kcl.",
            "1800-2200 kcl.",
            "1500-2000 kcl.",
            "1600-2100 kcl.",
            "1800-2300 kcl.",
            "1600-2200 kcl.",
            "1400-2000 kcl."
        ];
        $workouts = [
            "Strength training, walking, yoga, low-intensity cardio.",
            "Cardio (running, swimming), strength training, HIIT.",
            "Light to moderate workouts (walking, light resistance), or workouts during the eating window.",
            "Cardio and strength training (with adequate plant-based protein support).",
            "Functional fitness (e.g., CrossFit), running, hiking, weight lifting.",
            "Cardio, daily walking, swimming, light resistance training.",
            "Low to moderate intensity (walking, yoga, bodyweight exercises)."
        ];
        $image = [
            "diets/Keto.jpg",
            "diets/mediterranean.jpg",
            "diets/intermittent.jpeg",
            "diets/vegetarian.jpg",
            "diets/paleo.jpg",
            "diets/dash.jpg",
            "diets/low.jpeg"
        ];

        for ($i = 0; $i < 7; $i++) {
            Diet::create([
                'name'        => $name[$i],
                'description' => $description[$i],
                'calories'    => $kcl[$i],
                'workouts'    => $workouts[$i],
                'image'       => $image[$i],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
