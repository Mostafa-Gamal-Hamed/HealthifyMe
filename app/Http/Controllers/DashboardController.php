<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $dietInfo    = $user->dietInfo;
        $diets       = $user->diets()->orderby('id', 'desc')->get();
        $specialDiet = $user->specialDiet()->orderby('id', 'desc')->get();
        $info        = "Not null";

        $checkData = [];
        if ($dietInfo) {
            $checkData = [
                $dietInfo->age,
                $dietInfo->weight,
                $dietInfo->height,
                $dietInfo->gender,
                $dietInfo->activity_level,
                $dietInfo->workout_hours_per_week
            ];
        }
        foreach ($checkData as $data) {
            if ($data == null) {
                $info = null;
                break;
            }
        }

        // BMR
        $bmr = null;
        if ($dietInfo) {
            $bmr = match ($dietInfo->gender) {
                'male'   => round((10 * $dietInfo->weight) + (6.25 * $dietInfo->height) - (5 * $dietInfo->age) + 5),
                'female' => round((10 * $dietInfo->weight) + (6.25 * $dietInfo->height) - (5 * $dietInfo->age) - 161),
                default  => null,
            };
        }

        // TDEE
        $tdee = null;
        if ($bmr && isset($dietInfo->activity_level)) {
            $activity_levels = [
                'low'          => 1.2,
                'moderate'     => 1.375,
                'high'         => 1.725,
                'professional' => 1.9,
            ];

            $tdee = $bmr ? round(($bmr * ($activity_levels[$user->activity_level] ?? 1.2))) : null;
        }

        $lose_05kg  = $tdee ? round($tdee - 500) : null;
        $lose_1kg   = $tdee ? round($tdee - 1000) : null;
        $lose_1_5kg = $tdee ? round($tdee - 1500) : null;

        return view("dashboard", compact("user", "dietInfo", "diets", "specialDiet", "info", "tdee", "lose_05kg", "lose_1kg", "lose_1_5kg"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
