<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthyRecipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    public function index()
    {
        $categories = RecipeCategory::paginate(20);
        return view("admin.recipe.category.index", compact("categories"));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|unique:recipe_categories,name|min:3']);

        RecipeCategory::create($data);

        return redirect()->back()->with("success", "Category created successfully");
    }

    public function show(string $id)
    {
        $category = RecipeCategory::findOrFail($id);
        $recipes  = HealthyRecipe::where('recipe_category_id', $id)->get();

        return view("admin.recipe.category.show", compact("category", "recipes"));
    }

    public function edit(string $id)
    {
        $category = RecipeCategory::find($id);
        return view("admin.recipe.category.edit", compact("category"));
    }

    public function update(Request $request, string $id)
    {
        $category = RecipeCategory::findOrFail($id);

        $data = $request->validate(["name" => "required|string|unique:recipe_categories,name"]);

        $category->update($data);

        return redirect()->route("admin.recipeCategory.categories")->with("success", "Category updated successfully");
    }

    public function destroy(string $id)
    {
        $category = RecipeCategory::findOrFail($id);
        $category->delete();

        return redirect()->route("admin.recipeCategory.categories")->with('message', 'Category deleted successfully');
    }

    public function secondDestroy(string $id)
    {
        $category = RecipeCategory::findOrFail($id);
        $category->delete();

        return redirect()->route("admin.recipeCategory.categories")->with('message', 'Category deleted successfully');
    }
}
