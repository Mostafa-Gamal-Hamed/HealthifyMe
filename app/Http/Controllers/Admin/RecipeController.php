<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Models\HealthyRecipe;
use App\Models\RecipeLike;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = HealthyRecipe::orderby('id', 'desc')->paginate(20);
        return view("admin.recipe.index", compact("recipes"));
    }

    public function create()
    {
        return view("admin.recipe.create");
    }

    public function store(RecipeRequest $request)
    {
        $validated = $request->validated();

        $recipe = Recipe::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'calories' => $validated['calories'],
        ]);

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
            $recipe->video = $videoPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $recipe->images()->create(['path' => $imagePath]);
            }
        }

        return redirect()->route('admin.recipe.index')->with('success', 'Recipe created successfully!');
    }

    public function show(string $id)
    {
        $recipe   = HealthyRecipe::findOrFail($id);
        $likes    = RecipeLike::where("healthy_recipe_id", $id)->where('status', 'like')->count();
        $disLikes = RecipeLike::where("healthy_recipe_id", $id)->where('status', 'dislike')->count();

        return view("admin.recipe.show", compact("recipe", "likes", "disLikes"));
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

    public function search(string $search)
    {
        $recipes = HealthyRecipe::where('title', 'like', "%{$search}%")->get();

        return response()->json(['recipes' => $recipes]);
    }
}
