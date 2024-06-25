<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller {

  /**
   * Store a newly created resource in storage.
   */
  public function store (Request $request) {
    if ($request->isTweet) {
      $like = Like::where('user_id', $request->user_id)
                  ->where('tweet_id', $request->tweet_id)
                  ->where('tweet_id', '!=', null)
                  ->first();
      if ($like === null) {
        Like::create($request->only(['user_id', 'tweet_id']));
      } else {
        $like->delete();
      }
    } elseif ($request->isComment) {

      $like = Like::where('user_id', $request->user_id)
                  ->where('comment_id', $request->comment_id)
                  ->where('comment_id', '!=', null)
                  ->first();
//      dd($like->toArray());
      if ($like === null) {
        Like::create($request->only(['user_id', 'comment_id']));
      } else {
        $like->delete();
      }
    }

  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy ($id): RedirectResponse {
    $like = Like::find($id);

    $like->delete();

    return redirect()->back();
  }
}
