<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $redirect = Auth::user()->is_admin
                ? route('admin.dashboard')
                : route('dashboard');

            return redirect()->intended($redirect)
                ->with('toast', ['type' => 'success', 'message' => 'Welcome back, '.Auth::user()->name.'!']);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('toast', ['type' => 'danger', 'message' => 'Invalid email or password.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')
            ->with('toast', ['type' => 'info', 'message' => 'You have been logged out successfully.']);
    }
}
