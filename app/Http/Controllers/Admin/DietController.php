<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DietRequest;
use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

        if ($request->hasFile('image')) {
            $imagePath   = $request->file('image')->store('diets', 'public');
            $diet->image = $imagePath;
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
        if ($request->hasFile("image")) {
            // Remove old image
            $oldImage = $diet->image;
            if (!$oldImage) {
                Storage::delete($oldImage);
            }
            $newImage = Storage::putFile("diets", $request->validated()['image']);
        } else {
            $newImage = $diet->image;
        }

        $diet->update([
            "name"        => $request->validated()['name'],
            "description" => $request->validated()['description'],
            "calories"    => $request->validated()['calories'],
            "workouts"    => $request->validated()['workouts'],
            "image"       => $newImage,
        ]);

        return redirect()->back()->with('success', 'Diet updated successfully');
    }

    public function destroy(string $id)
    {
        $diet = Diet::findOrFail($id);

        // Remove images
        Storage::delete($diet->image);

        $diet->delete();

        return redirect()->back()->with('success', 'Diet deleted successfully');
    }

    public function search(string $search)
    {
        $diets = Diet::where('name', 'like', "%{$search}%")
        ->orWhere('calories', 'like', "%{$search}%")->get();

        return response()->json(['diets' => $diets]);
    }
}
