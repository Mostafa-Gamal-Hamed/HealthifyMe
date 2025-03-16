<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view("user.pages.contact");
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());

        return redirect()->back()->with(["success" => "Message sent successfully"]);
    }

    public function show(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
