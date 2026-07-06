<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if (config('is_mobile')) {
            return view('mobile.profile', ['user' => $request->user()]);
        }
        return view('profile.edit', ['user' => $request->user()]);
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
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar_cropped' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Decode base64
        $imageData = $request->avatar_cropped;
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        $imageData = base64_decode($imageData);

        // Hapus foto lama
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan file baru
        $filename = 'avatars/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $imageData);

        $user->update(['avatar' => $filename]);

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }
}


