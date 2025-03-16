<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DietRequest;
use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DietController extends Controller
{
    public function index()
    {
        $diets = Diet::orderby('id', 'desc')->paginate(20);

        return view('admin.diet.index', compact('diets'));
    }

    public function create()
    {
        return view("admin.diet.create");
    }

    public function store(DietRequest $request)
    {
        $diet = new Diet();
        $diet->fill($request->validated());

        // Store images and encode their paths as JSON
        $imgArray = [];
        if ($request->hasFile('images')) {
            foreach ($diet->images as $image) {
                $imgArray[] = Storage::putFile("diets", $image);
            }
            $diet->images = json_encode($imgArray);
        }

        $diet->save();

        return redirect()->back()->with('success', 'Diet Created successfully');
    }

    public function edit(string $id)
    {
        $diet = Diet::findOrFail($id);

        return view("admin.diet.edit", compact("diet"));
    }

    public function update(DietRequest $request, string $id)
    {
        $diet = Diet::findOrFail($id);

        // Images
        if ($request->hasFile("images")) {
            // Remove old image
            $oldImages = json_decode($diet->images);
            if (!$oldImages) {
                foreach ($oldImages as $oldImage) {
                    Storage::delete($oldImage);
                }
            }

            $imgArray = [];
            foreach ($request->images as $image) {
                $imgArray[] = Storage::putFile("diets", $image);
            }
            $newImages = json_encode($imgArray);
        }else {
            $newImages = $diet->images;
        }

        $diet->update([
            "name" => $request->validated()['name'],
            "description" => $request->validated()['description'],
            "calories" => $request->validated()['calories'],
            "workouts" => $request->validated()['workouts'],
            "images" => $newImages,
        ]);

        return redirect()->back()->with('success', 'Diet updated successfully');
    }

    public function destroy(string $id)
    {
        $diet = Diet::findOrFail($id);

        // Remove images
        $images = json_decode($diet->images);
        foreach ($images as $image) {
            Storage::delete($image);
        }

        $diet->delete();

        return redirect()->back()->with('success', 'Diet deleted successfully');
    }

    public function search(string $search)
    {
        $diets = Diet::where('name', 'like', "%{$search}%")
        ->orWhere('calories', 'like', "%{$search}%")
        ->get();

        return response()->json(['diets' => $diets]);
    }
}
