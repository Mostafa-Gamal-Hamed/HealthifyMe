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
        $user      = User::findOrFail($id);
        $dietInfo  = $user->dietInfo;
        $diets     = Diet::all();

        // BMR
        $bmr = null;
        if ($dietInfo) {
            $bmr = match ($dietInfo->gender) {
                'male'   => (10 * $dietInfo->weight) + (6.25 * $dietInfo->height) - (5 * $dietInfo->age) + 5,
                'female' => (10 * $dietInfo->weight) + (6.25 * $dietInfo->height) - (5 * $dietInfo->age) - 161,
                default  => null,
            };
        }

        // TDEE
        $activity_levels = [
            'low'          => 1.2,
            'moderate'     => 1.375,
            'high'         => 1.725,
            'professional' => 1.9,
        ];

        $tdee = $bmr ? ($bmr * ($activity_levels[$user->activity_level] ?? 1.2)) : null;

        $lose_05kg  = $tdee ? $tdee - 500 : null;
        $lose_1kg   = $tdee ? $tdee - 1000 : null;
        $lose_1_5kg = $tdee ? $tdee - 1500 : null;

        return view("admin.user.show", compact("user", "dietInfo", "diets", "bmr", "tdee", "lose_05kg", "lose_1kg", "lose_1_5kg"));
    }

    public function status(string $type, $id)
    {
        $user         = User::findOrFail($id);
        $askForDiet   = $user->askForDiet;
        $user->status = $type;
        $user->save();

        if ($type === "active") {
            foreach ($askForDiet as $askForDiet) {
                if ($askForDiet->ask === 'ask') {
                    $askForDiet->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'User status updated successfully');
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