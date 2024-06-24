<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index (Request $request) {
    $temp = Comment::where('tweet_id', request('tweet_id'))
                   ->withCount('likes')
                   ->with('user')
                   ->orderBy('id', 'desc') // Sort chronologically in descending order
                   ->get();

    $tweets = CommentResource::collection($temp);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store (Request $request) {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show (string $id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit (string $id) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update (Request $request, string $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy (string $id) {
    //
  }
}
