<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FeedController;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

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

    $user = (new UserResource($temp))->resolve();

    $canEdit = $username === Auth::user()->username;

    if ($canEdit) {
      $targetIsFollowed = false;
      $targetIsFollowing = false;
    } else {
      // I'm following the user or not
      $followedByUserIDs = array_column(Auth::user()->following->toArray(), 'followedUserId');

      $targetIsFollowed = in_array($user['id'], $followedByUserIDs, true);

      // is this user following me or not
      $followedByTargetIDs = array_column($user['following'], 'id');

      $targetIsFollowing = in_array(Auth::id(), $followedByTargetIDs, true);

      // dd($user, $followedIDs, $targetIsFollowed, $followingIDs, $targetIsFollowing);
    }

    $feedController = new FeedController();

    $allPosts = $feedController->getUserFeed($user['id']);

    $likedPosts = $feedController->getLikedPosts($user['id']);
    $replies = (new CommentController())->getProfileReplies($user['id']);


    return Inertia::render('settings/Profile', compact(
      "canEdit",
      "user",
      "targetIsFollowed",
      "targetIsFollowing",
      "allPosts",
      "likedPosts",
      "replies",
    ));
  }

  /**
   * Show the user's profile settings page.
   */
  public function edit(Request $request): Response {
    return Inertia::render('settings/Profile', [
      'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
      'status'          => $request->session()->get('status'),
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
   * Delete the user's profile.
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

    return redirect('/');
  }
}
