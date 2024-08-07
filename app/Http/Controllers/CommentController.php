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
    $temp = Comment::where('tweet_id', request('tweet_id'))
      ->with('user')
      ->withCount('likes')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->get();

    if ($temp !== null) {
      $likedCommentsIds = Like::select(['id', 'comment_id'])
        ->where('user_id', request('user_id'))
        ->whereNotNull('comment_id')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($temp as &$comment) {
        $comment->liked = $this->isLiked(
          needle: $comment->id,
          column_key: "comment_id"
        );
      }
    }

    return CommentResource::collection($temp)->toJson();
  }

  public function getProfileReplies(int $user_id): array {

    $temp = Comment::where('user_id', $user_id)
      ->with('user')
      ->withCount('likes')
      ->orderBy('id', 'desc') // Sort chronologically in descending order
      ->get();


    if ($temp !== null) {
      $likedCommentsIds = Like::select(['id', 'comment_id'])
        ->where('user_id', $user_id)
        ->whereNotNull('comment_id')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($temp as &$comment) {
        $comment->liked = $this->isLiked(
          needle: $comment->id,
          column_key: "comment_id"
        );
      }
    }

    return CommentResource::collection($temp)->resolve();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): void {
    $request->validate(['body' => 'required|max:255|string']);

    // user_id, tweet_id, body
    Comment::create([
      "user_id" => Auth::id(),
      "tweet_id" => $request->tweet_id,
      "body" => $request->body
    ]);


    $targetUser = User::find($request->target_id);

    $targetUser->notify(new CommentNotification($request->tweet_id));
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
      $likedCommentsIds = Like::select(['id', 'comment_id'])
        ->where('user_id', $request->user_id ?? Auth::user()->id)
        ->whereNotNull('comment_id')
        ->get()
        ->toArray();

      $this->setHaystack($likedCommentsIds);

      foreach ($comment as &$item) {
        $item->liked = $this->isLiked(
          needle: $item->id,
          column_key: "comment_id"
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
