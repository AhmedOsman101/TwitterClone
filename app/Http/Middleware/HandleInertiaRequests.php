<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware {
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array {
        $user = $request->user(); 
        return [
            ...parent::share($request),
            'auth' => [
                'user' => Auth::check() ? [
                    'id'              => $user->id,
                    'full_name'       => $user->full_name,
                    'username'        => $user->username,
                    'email'           => $user->email,
                    'bio'             => $user->bio,
                    'cover_photo'     => $user->cover_photo,
                    'profile_picture' => $user->profile_picture,
                ] : null,
            ],
        ];
    }
}
