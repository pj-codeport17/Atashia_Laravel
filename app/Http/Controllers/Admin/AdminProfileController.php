<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfilePictureService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function __construct(private ProfilePictureService $pictures) {}

    public function show(): View
    {
        $user = auth()->user();
        return view('admin.profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->safe()->except(['profile_picture', 'remove_picture', 'password']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $this->pictures->update(
            $user,
            $request->file('profile_picture'),
            $request->boolean('remove_picture'),
        );

        $user->update($data);

        return redirect()->route('admin.profile.show')
            ->with('toast', ['type' => 'success', 'message' => 'Profile updated successfully.']);
    }
}
