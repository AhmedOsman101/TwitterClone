<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Like;
use App\Models\Tweet;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller {
  use Helpers;

  /**
   * Store a newly created resource in storage.
   */
  public function store (Request $request) {


    $data = $request->validate([
      'body'    => 'required|max:280',
      'user_id' => 'required|exists:users,id',
    ]);

    Tweet::create($data);

    return redirect()->route('Home');

  }

  /**
   * Display the specified resource.
   */
  public function show ($id) {
    $tweet = Tweet::where('id', $id)->with('user')->withCount(['likes', 'comments'])->get();

    $tweet = TweetResource::collection($tweet);

    if ($tweet !== null) {
      $likedTweetsIds = Like::select(['id', 'tweet_id'])
                            ->where('user_id', Auth::user()->id)
                            ->where('tweet_id', '!=', null)
                            ->get()->toArray();

      foreach ($tweet as &$item) {
        $item->liked = $this->isLiked($item->id, $likedTweetsIds);
      }

    }
    $tweet = TweetResource::collection($tweet);
    
    return response()->json($tweet);
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
