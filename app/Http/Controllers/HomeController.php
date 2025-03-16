<?php

namespace App\Http\Controllers;

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
        if (Auth::user() && Auth::user()->role != 'user') {
            $users    = User::where('role', 'user')->get();
            $diets    = Diet::all();
            $special  = SpecialDiet::all();
            $blogs    = Blog::all();
            $messages = Contact::where("status", "unread")->orderby('id', 'desc')->take(10)->get();

            return view("admin.home", compact("users", "diets", "special", "blogs", "messages"));
        } else {
            $blogs = Blog::orderby('id', 'desc')->take(5)->get();
            return view("user.home", compact("blogs"));
        }
    }
}
