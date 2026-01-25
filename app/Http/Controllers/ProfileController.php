<?php
namespace App\Http\Controllers;

use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService) {}

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        Gate::authorize('update', $user->profile);

        $this->profileService->updateProfile($user, $request->validated());

        return back()->with('success', 'Profile updated correctly.');
    }
}