<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderby('id', 'desc')->paginate(20);
        return view("admin.category.index", compact("categories"));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|unique:categories,name']);

        Category::create($data);

        return redirect()->back()->with("success", "Category created successfully");
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view("admin.category.show", compact("category"));
    }

    public function edit(string $id)
    {
        $category = Category::find($id);
        return view("admin.category.edit", compact("category"));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate(['name' => 'required|string|unique:categories,name']);

        $category = Category::findOrFail($id);

        $category->update($data);

        return redirect()->route("admin.category.categories")->with("success", "Category updated successfully");
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with("success", "Category deleted successfully");
    }

    public function search(string $search)
    {
        $category = Category::where('name', 'like', "%{$search}%")->first();

        return response()->json(['category' => $category]);
    }

    public function secondDestroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route("admin.category.categories")->with('message', 'Category deleted successfully');
    }
}
