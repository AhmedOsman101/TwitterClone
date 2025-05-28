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

    $userId = $request->user()->id;
    if ($request->isTweet) {
      $like = Like::where('userId', $userId)
        ->where('tweetId', $request->tweetId)
        ->whereNotNull('tweetId')
        ->first();

      // If like exists delete its notification then delete the like
      if ($like !== null) {
        $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [ $like->notificationId ]);
        if ($deleted === 1) $like->delete();
      }

      // Else create a new like and notify the target user with it
      else {
        $createdLike = Like::create([
          "userId"  => $userId,
          "tweetId" => $request->tweetId,
        ]);

        $targetUser = $createdLike->tweet->user;

        $targetUser->notify(new LikeNotification(
          message: "{$createdLike->user->fullName} liked your tweet",
          tweetId: $createdLike->tweetId
        ));

        $createdLike->notificationId = $targetUser->notifications[0]->id; // Store notification UUID
        $createdLike->save();
      }
    }

    if ($request->isComment) {

      $like = Like::where('userId', $userId)
        ->where('commentId', $request->commentId)
        ->whereNotNull('commentId')
        ->first();

      // If like exists delete its notification then delete the like
      if ($like !== null) {
        $deleted = DB::delete('DELETE FROM notifications WHERE id = ?', [ $like->notificationId ]);
        if ($deleted === 1) $like->delete();
      }

      // Else create a new like and notify the target user with it
      else {
        $createdLike = Like::create([
          "userId"    => $userId,
          "commentId" => $request->commentId,
        ]);

        $targetUser = $createdLike->comment->user;

        $targetUser->notify(new LikeNotification(
          message: "{$createdLike->user->fullName} liked your comment",
          tweetId: $createdLike->comment->tweetId
        ));

        $createdLike->notificationId = $targetUser->notifications[0]->id; // Store notification UUID
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
