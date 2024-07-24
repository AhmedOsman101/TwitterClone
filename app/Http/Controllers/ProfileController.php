<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileUserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller {
  public function index($username): Response {
    // Retrieve the user with the specified username, including relationships
    $temp = User::where('username', $username)
      ->with([
        'following' => function ($query) {
          // Load the followed user details for the following relationship
          $query->with('followed');
        },
        'followers' => function ($query) {
          // Load the follower user details for the followers relationship
          $query->with('follower');
        }
      ])
      ->withCount(['following', 'followers'])
      ->firstOrFail(); // Throw an exception if the user is not found

    $user = (new ProfileUserResource($temp))->resolve();

    $isAuthUser = $username === Auth::user()->username;

    if ($isAuthUser) {
      $isFollowed = false;
      $isFollowing = false;
    } else {
      // I'm following the user or not
      $followedIDs = array_column(Auth::user()->following->toArray(), 'followed_user_id');

      $isFollowed = in_array($user['id'], $followedIDs, true);

      // is this user following me or not
      $followingIDs = array_column($user['following'], 'id');

      $isFollowing = in_array(Auth::id(), $followingIDs, true);
    }

    $feedController = new FeedController();

    $allPosts = $feedController->getUserFeed($user['id']);

    $likedPosts = $feedController->getLikedPosts($user['id']);
    $replies = (new CommentController())->getProfileReplies($user['id']);


    return Inertia::render('Profile/Profile', [
      "canEdit"     => $isAuthUser,
      "user"        => $user,
      "isFollowed"  => $isFollowed,
      "isFollowing" => $isFollowing,
      "allPosts"    => $allPosts,
      "likedPosts"  => $likedPosts,
      "replies"     => $replies,
    ]);
  }

  /**
   * Display the user's profile form.
   */
  public function edit(Request $request): Response {
    return Inertia::render('Profile/Edit', [
      'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
      'status'          => session('status'),
    ]);
  }

  /**
   * Update the user's profile information.
   */
  public function update(ProfileUpdateRequest $request): RedirectResponse {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route(
      'profile.edit',
      ['username' => $request->user()->username]
    );
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse {
    $request->validate([
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
