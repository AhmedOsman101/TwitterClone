<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Like;
use App\Models\Tweet;
use App\Traits\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FeedController extends Controller {
  use Helpers;

  public function HomeFeed (): Response|null {

    $feed = $this->getHomeFeed();

    return Inertia::render('Home', compact('feed'));
  }

  public function getHomeFeed (int|null $id = null): array {

    $tweets = Tweet::with('user')
                   ->orderBy('id', 'desc') // Sort chronologically in descending order
                   ->withCount(['likes', 'comments'])
                   ->get();

    $feed = TweetResource::collection($tweets);

    if ($feed !== null) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
                            ->where('user_id', $id ?? Auth::id())
                            ->where('tweet_id', '!=', null)
                            ->get()->toArray();

      $this->setHaystack($likedTweetsIds);
      foreach ($feed as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle    : $tweet->id,
          column_key: "tweet_id");
      }
    }

    return TweetResource::collection($feed)->resolve();
  }

  public function getUserFeed ($id): array {

    $tweets = Tweet::with('user')
                   ->where('user_id', $id)
                   ->orderBy('id', 'desc') // Sort chronologically in descending order
                   ->withCount(['likes', 'comments'])
                   ->get();

    $feed = TweetResource::collection($tweets);

    if ($feed !== null) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
                            ->where('user_id', $id)
                            ->where('tweet_id', '!=', null)
                            ->get()->toArray();

      $this->setHaystack($likedTweetsIds);
      
      foreach ($feed as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle    : $tweet->id,
          column_key: "tweet_id");
      }
    }

    return TweetResource::collection($feed)->resolve();
  }

  public function ApiHomeFeed (Request $request): JsonResponse {
    $feed = $this->getHomeFeed($request->user_id);

    return response()->json($feed);
  }
}
