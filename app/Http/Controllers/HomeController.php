<?php

namespace App\Http\Controllers;

use App\Models\AskForDiet;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Diet;
use App\Models\SpecialDiet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if (Auth::user() && Auth::user()->role != 'user' && Auth::user()->role != 'doctor') {
            $users      = User::where('role', 'user')->count();
            $diets      = Diet::count();
            $special    = SpecialDiet::count();
            $blogs      = Blog::count();
            $messages   = Contact::where("status", "unread")->orderby('id', 'desc')->take(10)->get();
            $askDiet    = AskForDiet::where('ask', 'ask')->count();
            $changeDiet = AskForDiet::where('ask', 'change')->count();

            return view("admin.home", compact("users", "diets", "special", "blogs", "messages", "askDiet", "changeDiet"));
        } else {
            $blogs = Blog::orderby('id', 'desc')->take(5)->get();
            return view("user.home", compact("blogs"));
        }
    }
}
