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
            return redirect()->route('home');
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
