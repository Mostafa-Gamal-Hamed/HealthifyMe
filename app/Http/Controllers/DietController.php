<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit  = 9;

        $diets  = Diet::latest()
            ->skip($offset)
            ->take($limit)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'diets' => $diets,
                'hasMore' => $diets->count() >= $limit
            ]);
        }

        return view("user.diet.index", compact("diets"));
    }

    public function show(string $id)
    {
        $diet = Diet::findOrFail($id);
        return view("user.diet.show", compact("diet"));
    }
}
