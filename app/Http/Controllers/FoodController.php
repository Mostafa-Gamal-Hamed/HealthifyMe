<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index($type)
    {
        $category = Category::where("name", $type)->first();
        $foods    = Food::where("category_id", $category->id)->get();

        $color = ['danger', 'dark', 'warning', 'success'];

        return view("user.food.index", compact("category", "foods", "color"));
    }

    public function show(string $id)
    {
        $food = Food::find($id);

        return response()->json([
            "success"  => true,
            "name"     => $food->name,
            "image"    => $food->image,
            "calories" => $food->calories,
            "protein"  => $food->protein,
            "carbs"    => $food->carbs,
            "fats"     => $food->fats,
            "vitamins" => $food->vitamins,
        ]);
    }
}
