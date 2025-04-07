<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Models\HealthyRecipe;
use App\Models\RecipeLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

        $video = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video')->store('recipes', 'public');
        }

        $images = null;
        if ($request->hasFile('images')) {
            $imgArray = [];
            foreach ($request->file('images') as $image) {
                $imgArray[] = $image->store('recipes', 'public');
            }
            $images = json_encode($imgArray);
        }

        HealthyRecipe::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'calories'    => $validated['calories'],
            'images'      => $images,
            'video'       => $video,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Recipe created successfully!');
    }

    public function show(string $id)
    {
        $recipe   = HealthyRecipe::findOrFail($id);
        $likes    = RecipeLike::where("healthy_recipe_id", $id)->where('status', 'like')->count();
        $disLikes = RecipeLike::where("healthy_recipe_id", $id)->where('status', 'dislike')->count();

        return view("admin.recipe.show", compact("recipe", "likes", "disLikes"));
    }

    public function edit(string $id)
    {
        $recipe = HealthyRecipe::findOrFail($id);
        return view("admin.recipe.edit", compact("recipe"));
    }

    public function update(RecipeRequest $request, string $id)
    {
        $recipe    = HealthyRecipe::findOrFail($id);
        $validated = $request->validated();

        $video = $recipe->video;
        if ($request->hasFile('video')) {
            if ($recipe->video) {
                Storage::disk('public')->delete($recipe->video);
            }
            $video = $request->file('video')->store('recipes', 'public');
        }

        $images = $recipe->images;
        if ($request->hasFile('images')) {
            if ($recipe->images) {
                $oldImages = json_decode($recipe->images);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $imgArray = [];
            foreach ($request->file('images') as $image) {
                $imgArray[] = $image->store('recipes', 'public');
            }
            $images = json_encode($imgArray);
        }

        $recipe->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'calories'    => $validated['calories'],
            'images'      => $images,
            'video'       => $video,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Recipe created successfully!');
    }

    public function destroy(string $id)
    {
        $recipe = HealthyRecipe::findOrFail($id);

        if ($recipe->video) {
            Storage::disk('public')->delete($recipe->video);
        }
        if ($recipe->images) {
            $oldImages = json_decode($recipe->images);
            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $recipe->delete();

        return redirect()->back()->with('success', 'Recipe deleted successfully!');
    }

    public function secondDestroy(string $id)
    {
        $recipe = HealthyRecipe::findOrFail($id);

        if ($recipe->video) {
            Storage::disk('public')->delete($recipe->video);
        }
        if ($recipe->images) {
            $oldImages = json_decode($recipe->images);
            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $recipe->delete();

        return redirect()->route("admin.recipe.recipes")->with('success', 'Recipe deleted successfully!');
    }

    public function search(string $search)
    {
        $recipes = HealthyRecipe::where('title', 'like', "%{$search}%")->get();

        return response()->json(['recipes' => $recipes]);
    }
}
