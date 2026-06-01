<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfilePictureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private ProfilePictureService $pictures) {}

    public function show(): View
    {
        return view('profile.show', ['user' => $this->authenticatedUser()]);
    }

    public function edit(): View
    {
        return view('profile.edit', ['user' => $this->authenticatedUser()]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $this->authenticatedUser();
        $data = $request->safe()->except(['profile_picture', 'remove_picture', 'password']);

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        $this->pictures->update(
            $user,
            $request->file('profile_picture'),
            $request->boolean('remove_picture')
        );

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('toast', ['type' => 'success', 'message' => 'Profile updated successfully.']);
    }
}
