<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SentMessageMail;
use App\Models\Contact;
use App\Models\SentMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $messages = Contact::orderByRaw("status = 'unread' DESC")->latest()->paginate(20);

        return view("admin.contact.index", compact("messages"));
    }

    public function show(string $id)
    {
        $message = Contact::findOrFail($id);

        if ($message->status == "unread") {
            $message->status = "read";
            $message->save();
        }

        return view("admin.contact.show", compact("message"));
    }

    public function secondDestroy(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function search(string $search)
    {
        $email = Contact::where('email', 'like', "%{$search}%")->first();

        return response()->json(['email' => $email]);
    }


    // Reply message
    public function allSent()
    {
        $messages = SentMessage::latest()->paginate(20);

        return view("admin.contact.sent.index", compact("messages"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'   => 'required|email|exists:contacts,email',
            'message' => 'required|string',
        ]);

        $contact = Contact::where('email', $request->email)->first();

        // Store message
        $sentMessage = SentMessage::create([
            'email'      => $request->email,
            'message'    => $request->message,
            'contact_id' => $contact->id,
            'user_id'    => Auth::id(),
        ]);

        // Send mail
        // $message = $request->message;
        Mail::to($request->email)->send(new SentMessageMail($sentMessage));

        return redirect()->back()->with('success', 'Email sent successfully!');
    }

    public function showSentMessage(string $id)
    {
        $message = SentMessage::findOrFail($id);

        return view("admin.contact.sent.show", compact("message"));
    }

    public function destroySentMessage(string $id)
    {
        $message = SentMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully!');
    }

    public function secondDestroySentMessage(string $id)
    {
        $message = SentMessage::findOrFail($id);
        $message->delete();

        return redirect()->route("admin.sentMessage.sentMessages")->with('success', 'Message deleted successfully!');
    }

    public function sentSearchMessage(string $search)
    {
        $emails = SentMessage::where('email', 'like', "%{$search}%")->with("user")->get();

        return response()->json(['emails' => $emails]);
    }
}
