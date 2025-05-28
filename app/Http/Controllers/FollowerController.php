<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShortUserResource;
use App\Models\Follower;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowerController extends Controller {
  public function store(Request $request): void {
    $follow = Follower::where('followerId', $request->followerId)
      ->where('followedUserId', $request->followedUserId)
      ->first();
    if ($follow !== null) {
      $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [ $follow->notificationId ]);
      if ($deleted === 1) {
        $follow->delete();
      }
    } else {
      $followedUser = User::find($request->followedUserId);

      // Send notification and get the notification model
      $followedUser->notify(new FollowNotification($request->followerId));

      // Create the follow relationship and store the notification ID
      $newFollow = Follower::create($request->all());
      $newFollow->notificationId = $followedUser->notifications[0]->id; // Store notification UUID
      $newFollow->save();
    }
  }

  public function randomFollowers(Request $request) {


    // Get the ID of the authenticated user
    $authUserId = $request->user()->id;

    // Use a subquery to get the IDs of the followed users and combine it with the authenticated user's ID
    $subQuery = Follower::where('followerId', $authUserId)
      ->select('followedUserId');

    // Get users not in the list of followed user IDs including the authenticated user's ID
    $query = User::whereNotIn('id', $subQuery)
      ->where('id', '!=', $authUserId) // Exclude the authenticated user's ID
      ->take(3)
      ->inRandomOrder()
      ->get();

    // Transform the query result into a collection
    $followSuggestions = ShortUserResource::collection($query)->resolve();

    return response()->json($followSuggestions);
  }
}
