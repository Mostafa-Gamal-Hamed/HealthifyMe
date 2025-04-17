<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate(["email" => "required|email|max:255|unique:newsletters,email"]);

        Newsletter::create($validate);

        return redirect()->back()->with("success", "You have been subscribed to our newsletter.");
    }
}
