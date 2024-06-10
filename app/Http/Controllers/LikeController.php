<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $exists = Like::where('user_id', $request->user_id)
            ->where('tweet_id', $request->tweet_id)
            ->exists();

        if ($request->has('create') && !$exists) {
            Like::create($request->only(['user_id', 'tweet_id']));
            return response()->json(['liked' => true]);
        }

        return response()->json(['liked' => $exists]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $like = Like::find($id);

        $like->destroy();

        return redirect()->back();
    }
}
