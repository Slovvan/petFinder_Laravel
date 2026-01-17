<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService) {}

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        
        // apply security policy
        Gate::authorize('update', $user->profile);

        // logic through sercicce
        $this->profileService->updateProfile($user, $request->validated());
        return back()->with('success', 'Profile updated correctly.');
    }
}