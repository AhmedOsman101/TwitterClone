<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = User::all();
        return dd($users);
    }

    /**
     * Register a newly created user in storage.
     */
    public function register(Request $request) {
        try {
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

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {
        return Inertia::render('Users/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $user = User::find($id);
            $user->update($request->all());
            return $user;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        try {
            $user = User::find($id);
            $user->delete();
            return $user;
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
