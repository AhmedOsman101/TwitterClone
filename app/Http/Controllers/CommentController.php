<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
  use Helpers;

  /**
   * Display a listing of the resource.
   */
  public function index(): string {
    $temp = Comment::where('tweetId', request('tweetId'))
      ->with('user')
      ->withCount('likes')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->get();

    if ($temp !== null) {
      $likedCommentsIds = Like::select([ 'id', 'commentId' ])
        ->where('userId', request('userId'))
        ->whereNotNull('commentId')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($temp as &$comment) {
        $comment->liked = $this->isLiked(
          needle: $comment->id,
          column_key: "commentId"
        );
      }
    }

    return CommentResource::collection($temp)->toJson();
  }

  public function getProfileReplies(int $userId): array {

    $temp = Comment::where('userId', $userId)
      ->with('user')
      ->withCount('likes')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->get();


    if ($temp !== null) {
      $likedCommentsIds = Like::select([ 'id', 'commentId' ])
        ->where('userId', $userId)
        ->whereNotNull('commentId')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($temp as &$comment) {
        $comment->liked = $this->isLiked(
          needle: $comment->id,
          column_key: "commentId"
        );
      }
    }

    return CommentResource::collection($temp)->resolve();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): void {
    $request->validate([ 'body' => 'required|max:255|string' ]);

    // userId, tweetId, body
    Comment::create([
      "userId"  => Auth::id(),
      "tweetId" => $request->tweetId,
      "body"    => $request->body,
    ]);


    $targetUser = User::find($request->targetId);

    $targetUser->notify(new CommentNotification($request->tweetId));
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, int $id): string {

    $comment = Comment::where('id', $id)
      ->with('user')
      ->withCount('likes')
      ->get();

    if ($comment->isNotEmpty()) {
      $likedCommentsIds = Like::select([ 'id', 'commentId' ])
        ->where('userId', $request->userId ?? Auth::user()->id)
        ->whereNotNull('commentId')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($comment as &$item) {
        $item->liked = $this->isLiked(
          needle: $item->id,
          column_key: "commentId"
        );
      }
    }
    $comment = CommentResource::collection($comment);
    return ($comment->toJson());
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id): void {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id): void {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id): void {
    //
  }
}
