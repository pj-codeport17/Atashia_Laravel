<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfilePictureService
{
    public function update(User $user, ?UploadedFile $file, bool $remove): void
    {
        if ($file) {
            $this->delete($user);
            $user->profile_picture = $file->store('avatars', 'public');

            return;
        }

        if ($remove) {
            $this->delete($user);
            $user->profile_picture = null;
        }
    }

    public function delete(User $user): void
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
    }
}
