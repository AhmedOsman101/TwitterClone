<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index () {
    try {
      return Comment::all();
    } catch (\Throwable $e) {
      dd($e);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store (Request $request) {
    try {
      return Comment::create($request->all());
    } catch (\Throwable $e) {
      dd($e);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show (string $id) {
    try {
      return Comment::findOrFail($id);
    } catch (\Throwable $e) {
      dd($e);
    }
  }
}
