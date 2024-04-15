<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        try {
            $posts = Post::all();
            return $posts;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $post = Post::create($request->all());
            return $post;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        try {
            $post = Post::findOrFail($id);
            return $post;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id) {
        try {
            $post = Post::find($id);
            if ($request->user()->id !== $post->user_id) {
                abort(403);
            }
            $post->update($request->all());
            return $post;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $post = Post::find($id);
            if ($request->user()->id !== $post->user_id) {
                abort(403);
            }
            $post->update($request->all());
            return $post;
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id) {
        try {
            $post = Post::find($id);
            if ($request->user()->id !== $post->user_id) {
                abort(403);
            }
            $post->delete();
            return $post;
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
