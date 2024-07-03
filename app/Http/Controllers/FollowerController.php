<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetUserResource;
use App\Models\Follower;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowerController extends Controller {
  public function store(Request $request): void {
    $follow = Follower::where('follower_id', $request->follower_id)
      ->where('followed_user_id', $request->followed_user_id)
      ->first();
    if ($follow !== null) {
      $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [$follow->notification_id]);
      if ($deleted === 1) {
        $follow->delete();
      }
    } else {
      $followedUser = User::find($request->followed_user_id);

      // Send notification and get the notification model
      $followedUser->notify(new FollowNotification($request->follower_id));

      // Create the follow relationship and store the notification ID
      $newFollow = Follower::create($request->all());
      $newFollow->notification_id = $followedUser->notifications[0]->id; // Store notification UUID
      $newFollow->save();
    }
  }

  public function randomFollowers(Request $request) {
    // Get the ID of the authenticated user
    $authUserId = $request->id;

    // Use a subquery to get the IDs of the followed users and combine it with the authenticated user's ID
    $subQuery = Follower::where('follower_id', $authUserId)
      ->select('followed_user_id');

    // Get users not in the list of followed user IDs including the authenticated user's ID
    $query = User::whereNotIn('id', $subQuery)
      ->where('id', '!=', $authUserId) // Exclude the authenticated user's ID
      ->take(3)
      ->inRandomOrder()
      ->get();

    // Transform the query result into a collection
    $followSuggestions = TweetUserResource::collection($query)->resolve();

    return response()->json($followSuggestions);
  }
}
