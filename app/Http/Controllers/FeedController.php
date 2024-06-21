<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Like;
use App\Models\Tweet;
use App\Traits\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FeedController extends Controller {
    use Helpers;

    public function HomeFeed(): Response|null {

        $feed = $this->getHomeFeed();

        return Inertia::render('Home', compact('feed'));
    }

    public function getHomeFeed($id = null): AnonymousResourceCollection {

        $tweets = Tweet::with('user')
            ->orderBy('id', 'desc') // Sort chronologically in descending order
            ->withCount(['likes', 'comments'])
            ->get();

        $feed = TweetResource::collection($tweets);

        if ($feed !== null) {
            $likedTweetsIds = Like::select(['id', 'tweet_id'])
                ->where('user_id', $id ?? Auth::user()->id)
                ->where('tweet_id', '!=', null)
                ->get()->toArray();

            foreach ($feed as &$tweet) {
                $tweet->liked = $this->isLiked($tweet->id, $likedTweetsIds);
            }
        }

        return TweetResource::collection($feed);
    }


    public function ApiHomeFeed(Request $request): JsonResponse {
        $feed = $this->getHomeFeed($request->user_id);

        return response()->json($feed);
    }
}
