<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ReceivedMessage;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view("user.pages.contact");
    }

    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        // Received email
        Mail::to("healthifyme@healthifyme.top")->send(new ReceivedMessage($contact));

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
