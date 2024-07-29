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
  public function store(Request $request): RedirectResponse {

    $request->validate(['body' => 'required|max:280']);

    Tweet::create([
      "user_id" => Auth::id(),
      "body" => $request->body,
    ]);

    return redirect()->route('Home');
  }

  /**
   * Send the specified resource.
   */
  public function ApiShow($id, Request $request): JsonResponse {
    $tweet = Tweet::find($id)
      ->with('user')
      ->withCount(['likes', 'comments'])
      ->first();

    if (!empty($tweet)) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
        ->where('user_id', $request->user()->id)
        ->whereNotNull('tweet_id')
        ->get()
        ->toArray();

      $this->setHaystack($likedTweetsIds);

      $tweet->liked = $this->isLiked(
        needle: $tweet->id,
        column_key: "tweet_id"
      );
    }

    $tweet = TweetResource::make($tweet)->resolve();

    return response()->json($tweet);
  }

  /**
   * Send the specified resource.
   */
  public function show(Request $request): Response {
    $tweet = Tweet::find($request->id)
      ->with('user')
      ->withCount(['likes', 'comments'])
      ->first();

    if (!empty($tweet)) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
        ->where('user_id', $request->user()->id)
        ->whereNotNull('tweet_id')
        ->get()
        ->toArray();

      $this->setHaystack($likedTweetsIds);

      $tweet->liked = $this->isLiked(
        needle: $tweet->id,
        column_key: "tweet_id"
      );
    }


    $tweet = TweetResource::make($tweet)->resolve();


    return Inertia::render('SingleTweet', compact('tweet'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id) {
    //
  }
}
