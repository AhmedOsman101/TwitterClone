<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Like;
use App\Models\Tweet;
use App\Traits\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TweetController extends Controller {
  use Helpers;

  /**
   * Store a newly created resource in storage.
   */
  public function store (Request $request): RedirectResponse {

    $data = $request->validate([
      'body'    => 'required|max:280',
      'user_id' => 'required|exists:users,id',
    ]);

    Tweet::create($data);

    return redirect()->route('Home');
  }

  /**
   * Send the specified resource.
   */
  public function ApiShow ($id, Request $request): JsonResponse {
    $tweet = Tweet::where('id', $id)->with('user')->withCount(['likes', 'comments'])->get();

    if ($tweet->isNotEmpty()) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
                            ->where('user_id', $request->user_id ?? Auth::id())
                            ->whereNotNull('tweet_id')
                            ->get()->toArray();

      $this->setHaystack($likedTweetsIds);

      $tweet = $tweet->map(function ($tweet) {
        $tweetResource = new TweetResource($tweet);
        $tweetResource->liked = $this->isLiked(
          needle    : $tweet->id,
          column_key: "tweet_id");
        return $tweetResource;
      });
    }
    $tweet = TweetResource::collection($tweet);

    return response()->json($tweet);
  }

  /**
   * Send the specified resource.
   */
  public function show (Request $request): Response {
    $tweet = Tweet::where('id', $request->id)->with('user')->withCount(['likes', 'comments'])->get();

    if ($tweet->isNotEmpty()) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
                            ->where('user_id', $request->user_id ?? Auth::id())
                            ->where('tweet_id', '!=', null)
                            ->get()->toArray();

      $this->setHaystack($likedTweetsIds);

      $tweet = $tweet->map(function ($tweet) {
        $tweetResource = new TweetResource($tweet);

        $tweetResource->liked = $this->isLiked(
          needle    : $tweet->id,
          column_key: "tweet_id");

        return $tweetResource;
      });
    }
    $tweet = TweetResource::collection($tweet)->resolve();

    return Inertia::render('SingleTweet', compact('tweet'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit ($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update (Request $request, $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy ($id) {
    //
  }
}
