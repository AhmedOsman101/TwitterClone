<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller {
    /**
     * Register a newly created user in storage.
     */
    public function register(Request $request) {
        try {

            $credentials = $request->validate([
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8'],
                'full_name' => ['required', 'min:3'],
                'username' => ['required', 'unique:users'],
            ]);

            $user = User::create($request->all());

            Auth::loginUsingId($user->id);

            return Inertia::render('Home', [
                'user' => $user,
            ]);
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        // logout the user
        Auth::logout();

        // invalidate the user's session
        $request->session()->invalidate();

        // regenerate the CSRF token
        $request->session()->regenerateToken();

        // redirect the user to the homepage
        return redirect('/');
    }
}
