<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            $comments = Comment::all();
            return $comments;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $comment = Comment::create($request->all());
            return $comment;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        try {
            $comment = Comment::findOrFail($id);
            return $comment;
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
