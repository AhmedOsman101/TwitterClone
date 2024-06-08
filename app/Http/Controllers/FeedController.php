<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedController extends Controller
{
    public function HomeFeed(): \Inertia\Response
    {
        $userId = Auth::user()->id; // Get the authenticated user's ID
        $oneHourAgo = now()->subHour(); // Get the time for one hour ago

        $feed = Tweet::with('user')->where('user_id', '!=', $userId) // Exclude the user's old posts
        ->orWhere(function ($query) use ($userId, $oneHourAgo) {
            $query->where('user_id', $userId)
                ->where('created_at', '>', $oneHourAgo); // Include user's new posts from the last hour
        })
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();

        return Inertia::render('Pages/Home', compact('feed'));

    }

    public function UserFeed(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $userId = $request->user_id; // Get the authenticated user's ID

        return Tweet::with('user')
            ->where('id', $userId)
            ->orderBy('created_at', 'desc');

    }


}
