<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller {

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $like = Like::where('user_id', $request->user_id)
            ->where('tweet_id', $request->tweet_id)
            ->first();

        if ($like === null) {
            Like::create($request->only(['user_id', 'tweet_id']));
        } else {
            $like->delete();
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
