<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller {

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    if ($request->isTweet) {
      $like = Like::where('user_id', $request->user_id)
        ->where('tweet_id', $request->tweet_id)
        ->where('tweet_id', '!=', null)
        ->first();
      if ($like !== null) $like->delete();
      else Like::create($request->only(['user_id', 'tweet_id']));
      return;
    }

    if ($request->isComment) {

      $like = Like::where('user_id', $request->user_id)
        ->where('comment_id', $request->comment_id)
        ->where('comment_id', '!=', null)
        ->first();
      if ($like !== null) {
        $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [$like->notification_id]);
        if ($deleted === 1) {
          $like->delete();
        }
      } else {
        Like::create($request->only(['user_id', 'comment_id']));
      }

      return;
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id): RedirectResponse {
    $like = Like::find($id);

    $like->delete();

    return redirect()->back();
  }
}
