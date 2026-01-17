<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileDeleteRequest;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Services\ProfilService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(protected ProfilService $profileService) {}

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request)
    {
        $request->user()->profile()->firstOrCreate();

        return view('settings.profile');
    }

    /**
     * Update the user's profile settings.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->fill(collect($validated)->only(['name', 'email'])->toArray());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $this->profileService->updateProfile(
            $request->user(),
            [
                'bio' => $validated['bio'] ?? null,
                'profile_photo' => $request->file('profile_photo'),
            ]
        );

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
