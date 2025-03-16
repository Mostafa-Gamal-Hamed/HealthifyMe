<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DietRequest;
use App\Models\Diet;
use App\Models\SpecialDiet;
use App\Models\User;
use App\Models\UserDiet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->orderby('id', 'desc')->paginate(20);

        return view("admin.user.index", compact("users"));
    }

    public function show(string $id)
    {
        $user  = User::findOrFail($id);
        $diets = Diet::all();

        return view("admin.user.show", compact("user", "diets"));
    }

    public function status(string $type, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $type;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }

    public function userDiet(Request $request)
    {
        // Validate
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'diet_id' => 'required|exists:diets,id',
        ]);

        UserDiet::create($data);

        return redirect()->back()->with('success', 'Diet selected successfully');
    }

    public function userSpecialDiet(DietRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $diet = new SpecialDiet();
        $diet->fill($request->validated());
        $diet->user_id = $user->id;

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

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->diets()->detach();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function search(string $search)
    {
        $users = User::where('role', 'user')->whereAny([
            'firstName',
            'lastName',
            'email',
            ], 'like', "%{$search}%")->get();

        return response()->json(['users' => $users]);
    }
}
