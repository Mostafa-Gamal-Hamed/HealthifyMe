<?php

namespace App\Http\Controllers;

use App\Http\Requests\DietInfoRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DietInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function dietUpdate(DietInfoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        DietInfo::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'age'                    => $data['age'],
                'weight'                 => $data['weight'],
                'height'                 => $data['height'],
                'gender'                 => $data['gender'],
                'activity_level'         => $data['activity_level'],
                'workout_hours_per_week' => $data['workout_hours_per_week'],
                'bodyFat'                => $data['bodyFat'],
                'bodyWater'              => $data['bodyWater'],
                'target'                 => $data['target'],
                'diseases'               => $data['diseases'],
                'treatment'              => $data['treatment'],
            ]
        );

        return Redirect::route('profile.edit')->with('success', 'Updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
