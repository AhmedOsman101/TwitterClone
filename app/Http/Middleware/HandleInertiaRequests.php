<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware {
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array {
        $user = Auth::user();
        return array_merge(parent::share($request), [
            'auth' => Auth::check() ? [
                'user' => [
                    'id' => $user->id,
                    'fullname' => $user->full_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'bio' => $user->bio,
                    'cover_photo' => $user->cover_photo,
                    'profile_picture' => $user->profile_picture,
                ]
            ] : null
        ]);
    }
}
