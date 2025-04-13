<?php

namespace App\Http\Controllers;

use App\Models\HealthyRecipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class HealthyRecipeController extends Controller
{
    public function index(Request $request)
    {
        $offset  = $request->input('offset', 0);
        $limit   = 9;
        $recipes = HealthyRecipe::with(['category', 'user'])->latest()->skip($offset)
        ->take($limit)->get()->map(function($recipe) {
            $recipe->images = json_decode($recipe->images, true);
            return $recipe;
        });

        if ($request->ajax()) {
            return response()->json([
                'recipes' => $recipes,
                'hasMore' => $recipes->count() >= $limit
            ]);
        }

        return view("user.recipe.index", compact("recipes"));
    }

    public function category(Request $request, $category)
    {
        $offset  = $request->input('offset', 0);
        $limit   = 9;

        $category = RecipeCategory::where("name", $category)->first();
        $recipes  = HealthyRecipe::where("recipe_category_id", $category->id)->with(['category', 'user'])->latest()->skip($offset)
        ->take($limit)->get()->map(function($recipe) {
            $recipe->images = json_decode($recipe->images, true);
            return $recipe;
        });

        return view("user.recipe.category", compact("category", "recipes"));
    }

    public function show(string $id)
    {
        $recipe = HealthyRecipe::findOrFail($id);

        return view("user.recipe.show", compact("recipe"));
    }

    public function search(Request $request)
    {
        $request->validate(["search" => "required|string|max:255"]);
        $search = $request->input("search");

        $recipes = HealthyRecipe::where("title", "like", "%$search%")
        ->with(['category', 'user'])->latest()->get()->map(function($recipe) {
            $recipe->images = json_decode($recipe->images, true);
            return $recipe;
        });

        return view("user.recipe.index", compact("recipes", "search"));
    }
}
