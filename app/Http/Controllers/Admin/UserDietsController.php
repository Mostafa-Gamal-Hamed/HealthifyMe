<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDiet;
use Illuminate\Http\Request;

class UserDietsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validate
        $request->validate([
            'diet_id' => 'required|exists:diets,id',
        ]);

        UserDiet::create([
            'user_id' => $user->id,
            'diet_id' => $request->diet_id,
        ]);

        return redirect()->back()->with('success', 'Diet selected successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $diet = UserDiet::where("diet_id", $id)->first();

        if (!$diet) {
            return redirect()->back()->with('error' , 'Diet not found');
        }

        $diet->delete();
        return redirect()->back()->with('success' , 'Diet deleted successfully');
    }
}
