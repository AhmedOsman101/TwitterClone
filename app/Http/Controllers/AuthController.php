<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a newly created user in storage.
     */
    public function register(Request $request): RedirectResponse
    {


        $credentials = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'full_name' => ['required', 'min:3'],
            'username' => ['required', 'min:3', 'unique:users', 'regex:/^\S+$/', 'lowercase'],
        ]);

        User::create($credentials);

        $this->login($request, true);

        return redirect()->route('Home');

    }

    public function login(Request $request, $isRemembered = false): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Get the 'remember' form field
        $remember = $isRemembered || ($request->has('remember') && $request->remember === true);

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        // logout the user
        Auth::logout();

        // invalidate the user's session
        $request->session()->invalidate();

        // regenerate the CSRF token
        $request->session()->regenerateToken();

        // redirect the user to the homepage
        return redirect()->route('login');
    }
}
