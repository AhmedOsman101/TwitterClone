<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller {
  /**
   * Show the registration page.
   */
  public function create(): Response {
    return Inertia::render('auth/Register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse {
    $request->validate([
      'fullName' => 'required|string|max:255|min:3',
      'email'    => 'required|string|lowercase|email|max:255|unique:users',
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'username' => ['required', 'min:3', 'unique:users', 'regex:/^[A-Za-z0-9]+$/'],
    ]);

    $user = User::create([
      'fullName' => $request->fulName,
      'username' => $request->username,
      'email'    => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return to_route('home');
  }
}
