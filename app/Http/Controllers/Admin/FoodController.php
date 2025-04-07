<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::orderby("id", "desc")->paginate(20);

        return view("admin.food.index", compact("foods"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.food.create", compact("categories"));
    }

    public function store(FoodRequest $request)
    {
        $food = new Food();
        $data = $request->validated();

        // Image
        $image = Storage::putFile("foods", $request->validated()['image']);
        $data['image'] = $image;

        $food->fill($data);

        $food->save();

        return redirect()->back()->with("success", "Food created successfully");
    }

    public function show(string $id)
    {
        $food = Food::findOrFail($id);
        return view("admin.food.show", compact("food"));
    }

    public function edit(string $id)
    {
        $food = Food::findOrFail($id);
        $categories = Category::all();

        return view("admin.food.edit", compact("food", "categories"));
    }

    public function update(FoodRequest $request, string $id)
    {
        $food = Food::findOrFail($id);

        // Image
        if ($request->hasFile("image")) {
            // Remove old image
            if ($food->image) {
                Storage::delete($food->image);
            }

            $newImage = Storage::putFile("foods", $request->validated()['image']);
        } else {
            $newImage = $food->image;
        }

        $food->update([
            'name'        => $request->validated()['name'],
            'category_id' => $request->validated()['category_id'],
            'calories'    => $request->validated()['calories'],
            'protein'     => $request->validated()['protein'],
            'carbs'       => $request->validated()['carbs'],
            'fats'        => $request->validated()['fats'],
            'vitamins'    => $request->validated()['vitamins'],
            'image'       => $newImage,
        ]);

        return redirect()->back()->with("success", "Food updated successfully");
    }

    public function destroy(string $id)
    {
        $food = Food::findOrFail($id);

        if ($food->image) {
            Storage::delete($food->image);
        }

        $food->delete();

        return redirect()->back()->with("success", "Food deleted successfully");
    }

    public function secondDestroy(string $id)
    {
        $food = Food::findOrFail($id);

        if ($food->image) {
            Storage::delete($food->image);
        }

        $food->delete();

        return redirect()->route("admin.food.foods")->with("success", "Food deleted successfully");
    }

    public function search(string $search)
    {
        $food = Food::whereLike('name', "%$search%")->with('category')->first();

        return response()->json(['food' => $food]);
    }
}
