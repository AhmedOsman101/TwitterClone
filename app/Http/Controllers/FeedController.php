<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Traits\Helpers;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedController extends Controller
{
    use Helpers;

    public function HomeFeed(): \Inertia\Response|null
    {

        $userId = Auth::user()->id; // Get the authenticated user's ID
        $oneHourAgo = now()->subHour(); // Get the time for one hour ago

        $feed = Tweet::with([
            'user' => function ($query) {
                $query->select('id', 'full_name', 'username', 'profile_picture');
            }
        ])
            ->select('id', 'user_id', 'body', 'likes_count', 'comments_count', 'created_at') // Select only required columns from the tweets table
            ->where('user_id', '!=', $userId) // Exclude the user's old posts
            ->orWhere(function ($query) use ($userId, $oneHourAgo) {
                $query->where('user_id', $userId)
                    ->where('created_at', '>', $oneHourAgo); // Include user's new posts from the last hour
            })
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();


        foreach ($feed as $item) {
            $item->duration = $this->ModifyDate($item->created_at);
        }

        return Inertia::render('Pages/Home', compact('feed'));
    }


    public function UserFeed(Request $request): Builder
    {
        $userId = $request->user_id; // Get the authenticated user's ID

        $feed = Tweet::with(['user' => function ($query) {
            $query->select('id', 'full_name', 'username', 'likes_count', 'comments_count', 'profile_picture');
        }])
            ->select('id', 'user_id', 'body', 'created_at') // Select only required columns from the tweets table
            ->where('id', $userId)
            ->orderBy('created_at', 'desc');

        foreach ($feed as $item) {
            $item->duration = $this->ModifyDate($item->created_at);
        }

        return $feed;
    }
}
