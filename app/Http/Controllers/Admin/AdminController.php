<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['superAdmin', 'admin'])->latest()->paginate(20);
        return view("admin.admin.index", compact("admins"));
    }

    public function create()
    {
        return view("admin.admin.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'      => ['required', 'in:admin,superAdmin'],
            'password'  => ['required', 'confirmed', Password::defaults()->min(8)->mixedCase()->symbols()],
        ]);

        User::create([
            'firstName' => $request->firstName,
            'lastName'  => $request->lastName,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', "$request->role added successfully");
    }

    public function show(string $id)
    {
        $admin     = User::findOrFail($id);
        $dietInfo  = $admin->dietInfo;
        return view("admin.admin.show", compact("admin", "dietInfo"));
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
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route("admin.admin.admins")->with('success', "Admin deleted successfully");
    }

    public function search(string $search)
    {
        $admins = User::whereIn('role', ['superAdmin', 'admin'])->whereAny([
            'firstName',
            'lastName',
            'email',
        ], 'like', "%{$search}%")->get();

        return response()->json(['admins' => $admins]);
    }
}
