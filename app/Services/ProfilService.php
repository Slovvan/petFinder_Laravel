<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService {
    public function updateProfile(User $user, array $data)
    {
        $profile = $user->profile;

        if (isset($data['profile_photo'])) {
            // delete old
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }

            // save in public/profil
            $path = $data['profile_photo']->store('profiles', 'public');
            $profile->profile_photo = $path;
        }

        $profile->bio = $data['bio'] ?? $profile->bio;
        $profile->save();

        return $profile;
    }
}