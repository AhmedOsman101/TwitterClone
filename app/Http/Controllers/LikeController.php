<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Notifications\LikeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller {

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {

    // dd($request->all(), $request->user());

    $user_id = $request->user()->id;
    if ($request->isTweet) {
      $like = Like::where('user_id', $user_id)
        ->where('tweet_id', $request->tweet_id)
        ->whereNotNull('tweet_id')
        ->first();

      // If like exists delete its notification then delete the like
      if ($like !== null) {
        $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [$like->notification_id]);
        if ($deleted === 1) $like->delete();
      }

      // Else create a new like and notify the target user with it
      else {
        $createdLike = Like::create([
          "user_id"  => $user_id,
          "tweet_id" => $request->tweet_id
        ]);

        $targetUser = $createdLike->tweet->user;

        $targetUser->notify(new LikeNotification(
          message: "{$createdLike->user->full_name} liked your tweet",
          tweet_id: $createdLike->tweet_id
        ));

        $createdLike->notification_id = $targetUser->notifications[0]->id; // Store notification UUID
        $createdLike->save();
      }
    }

    if ($request->isComment) {

      $like = Like::where('user_id', $user_id)
        ->where('comment_id', $request->comment_id)
        ->whereNotNull('comment_id')
        ->first();

      // If like exists delete its notification then delete the like
      if ($like !== null) {
        $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [$like->notification_id]);
        if ($deleted === 1) $like->delete();
      }

      // Else create a new like and notify the target user with it
      else {
        $createdLike = Like::create([
          "user_id"    => $user_id,
          "comment_id" => $request->comment_id
        ]);

        $targetUser = $createdLike->comment->user;

        $targetUser->notify(new LikeNotification(
          message: "{$createdLike->user->full_name} liked your comment",
          tweet_id: $createdLike->comment->tweet_id
        ));

        $createdLike->notification_id = $targetUser->notifications[0]->id; // Store notification UUID
        $createdLike->save();
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id): RedirectResponse {
    Like::find($id)->delete();

    return redirect()->back();
  }
}
