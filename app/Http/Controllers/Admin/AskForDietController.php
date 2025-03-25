<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AskForDiet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AskForDietController extends Controller
{
    public function ask()
    {
        $user = Auth::user();

        if ($user->status == 'active') {
            return redirect()->back()->with("error", 'You already asked for diet');
        }

        AskForDiet::create([
            'user_id' => $user->id,
            'ask' => 'ask',
        ]);

        return redirect()->back()->with("success", 'Diet request sent successfully');
    }

    public function change()
    {
        $user = Auth::user();

        if ($user->status == 'inactive') {
            return redirect()->back()->with("error", 'You already asked for diet');
        }

        AskForDiet::create([
            'user_id' => $user->id,
            'ask' => 'change',
            'accept' => 1
        ]);

        return redirect()->back()->with("success", 'Change diet request sent successfully');
    }
}
