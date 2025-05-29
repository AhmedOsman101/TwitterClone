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

  public function HomeFeed(): Response|null {

    $feed = $this->getHomeFeed();

    return Inertia::render('home', compact('feed'));
  }

  public function getHomeFeed(int|null $id = null): array {

    $tweets = Tweet::with('user')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->withCount(['likes', 'comments'])
      ->get();

    $feed = TweetResource::collection($tweets);

    if ($feed !== null) {
      $likedTweetsIds = Like::select(['id', 'tweetId'])
        ->where('userId', $id ?? Auth::id())
        ->where('tweetId', '!=', null)
        ->get()->toArray();

      $this->setHaystack($likedTweetsIds);
      foreach ($feed as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle: $tweet->id,
          column_key: "tweetId"
        );
      }
    }

    return TweetResource::collection($feed)->resolve();
  }

  public function getUserFeed(int $id): array {

    $tweets = Tweet::with('user')
      ->where('userId', $id)
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->withCount(['likes', 'comments'])
      ->get();

    $feed = TweetResource::collection($tweets);

    if ($feed !== null) {
      $likedTweetsIds = Like::select(['id', 'tweetId'])
        ->where('userId', $id)
        ->where('tweetId', '!=', null)
        ->get()->toArray();

      $this->setHaystack($likedTweetsIds);

      foreach ($feed as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle: $tweet->id,
          column_key: "tweetId"
        );
      }
    }

    return TweetResource::collection($feed)->resolve();
  }

  public function ApiHomeFeed(Request $request): JsonResponse {
    $feed = $this->getHomeFeed($request->userId);

    return response()->json($feed);
  }

  public function getLikedPosts($targetId): array {

    $tweets = Tweet::whereHas('likes', function ($query) use ($targetId) {
      $query->where('userId', $targetId);
    })
      ->with('user')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->withCount(['likes', 'comments'])
      ->get();

    $tweets = TweetResource::collection($tweets);

    if ($tweets !== null) {
      $likedTweetsIds = Like::select(['id', 'tweetId'])
        ->where('userId', Auth::id())
        ->whereNotNull('tweetId')
        ->get()
        ->toArray();

      $this->setHaystack($likedTweetsIds);

      foreach ($tweets as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle: $tweet->id,
          column_key: "tweetId"
        );
      }
    }
    return TweetResource::collection($tweets)->resolve();
  }

  public function getReplies($targetId): array {

    $tweets = Tweet::whereHas('comments', function ($query) use ($targetId) {
      $query->where('userId', $targetId);
    })
      ->with('user')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->withCount(['likes', 'comments'])
      ->get();

    $tweets = TweetResource::collection($tweets);

    if ($tweets !== null) {
      $likedTweetsIds = Like::select(['id', 'tweetId'])
        ->where('userId', Auth::id())
        ->whereNotNull('tweetId')
        ->get()
        ->toArray();

      $this->setHaystack($likedTweetsIds);

      foreach ($tweets as &$tweet) {
        $tweet->liked = $this->isLiked(
          needle: $tweet->id,
          column_key: "tweetId"
        );
      }
    }
    return TweetResource::collection($tweets)->resolve();
  }
}
