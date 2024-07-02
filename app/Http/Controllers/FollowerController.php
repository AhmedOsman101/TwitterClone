<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetUserResource;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller {
  public function store (Request $request): void {
    $follow = Follower::where('follower_id', $request->follower_id)
                      ->where('followed_user_id', $request->followed_user_id)
                      ->first();
    if ($follow !== null) $follow->delete();
    else Follower::create($request->all());
  }

  public function randomFollowers (Request $request) {
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
