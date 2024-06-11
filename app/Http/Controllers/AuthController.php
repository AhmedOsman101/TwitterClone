<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {


  public function getAuthenticatedUser (): \Illuminate\Http\JsonResponse {

    if (!Auth::check()) {
      return response()->json(['user' => null]);
    }

    $user = Auth::user();
    return response()->json([
      'user' => [
        'id'              => $user->id,
        'full_name'       => $user->full_name,
        'username'        => $user->username,
        'email'           => $user->email,
        'bio'             => $user->bio,
        'cover_photo'     => $user->cover_photo,
        'profile_picture' => $user->profile_picture,
      ],
    ]);
  }

  /**
   * Register a newly created user in storage.
   */
  public function register (Request $request): RedirectResponse {


    $credentials = $request->validate([
      'email'     => ['required', 'email', 'unique:users'],
      'password'  => ['required', 'min:8', 'confirmed'],
      'full_name' => ['required', 'min:3'],
      'username'  => ['required', 'min:3', 'unique:users', 'regex:/^\S+$/', 'lowercase'],
    ]);

    $user = User::create($credentials);

    Auth::loginUsingId($user->id, true);

    return redirect()->route('Home');

  }

  public function login (Request $request, $isRemembered = false): RedirectResponse {
    $credentials = $request->validate([
      'email'    => ['required', 'email'],
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

  public function logout (Request $request): RedirectResponse {
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
