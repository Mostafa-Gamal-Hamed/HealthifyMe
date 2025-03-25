<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AskForDiet;
use Illuminate\Http\Request;

class DietRequestController extends Controller
{
    public function index()
    {
        $dietRequests = AskForDiet::orderby('id', 'desc')->paginate(20);
        return view("admin.user.dietRequest.index", compact("dietRequests"));
    }

    public function show($id)
    {
        $dietRequest = AskForDiet::findOrFail($id);
        return view("admin.user.dietRequest.show", compact("dietRequest"));
    }

    public function destroy($id)
    {
        $dietRequests = AskForDiet::FindOrFail($id);
        $dietRequests->delete();

        return redirect()->back()->with("success", "Diet Request Deleted Successfully");
    }

    public function search(string $search)
    {
        $requests = AskForDiet::with('user')->where('ask', 'like', "%{$search}%")
        ->orWhereHas('user', function ($query) use ($search) {
            $query->where('firstName', 'like', "%{$search}%");
        })->get();

        return response()->json(['requests' => $requests]);
    }
}
