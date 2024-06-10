<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedController extends Controller
{
    public function HomeFeed(): \Inertia\Response|null
    {

        $userId = Auth::user()->id; // Get the authenticated user's ID
        $oneHourAgo = now()->subHour(); // Get the time for one hour ago

        $feed = Tweet::with(['user' => function ($query) {
            $query->select('id', 'full_name', 'username', 'profile_picture');
        }])
            ->select('id', 'user_id', 'body', 'created_at') // Select only required columns from the tweets table
            ->where('user_id', '!=', $userId) // Exclude the user's old posts
            ->orWhere(function ($query) use ($userId, $oneHourAgo) {
                $query->where('user_id', $userId)
                    ->where('created_at', '>', $oneHourAgo); // Include user's new posts from the last hour
            })
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->withCount(['comments', 'likes'])
            ->get();


        foreach ($feed as $item) {
            $item->duration = $this->ModifyDate($item->created_at);
        }

        return Inertia::render('Pages/Home', compact('feed'));
    }

    public function ModifyDate($date): string
    {
        // calculate the difference, displays in two parts e.g: '1w 2d from now'
        $diff = now()->shortRelativeToNowDiffForHumans($date, 2);
        // separate the parts
        $diff = explode(' ', $diff);
        // store the two main parts
        $diffFirst = $diff[0];
        $diffSecond = $diff[1];

        $month = $date->shortEnglishMonth;
        $day = $date->day;
        $year = $date->year;

        if (preg_match('/^\d+(s)$/i', $diffFirst)) {

            if (substr($diffFirst, 0, -1) <= 9) return "Just now";
            return $diffFirst;
        }

        if (preg_match('/^\d+([smhd])$/i', $diffFirst)) {
            return $diffFirst;
        }

        if (
            str_contains($diffFirst, '1w')
            && !preg_match('/^\d+(d)$/i', $diffSecond)
        ) {
            return $diffFirst;
        }

        if (preg_match('/^\d+(w|mo)$/i', $diffFirst)) {

            return "$month $day";
        }

        if (preg_match('/^\d+(yr)$/i', $diffFirst)) {
            return "$month $day, $year";
        }

        return $diffFirst;
    }

    public function UserFeed(Request $request): Builder
    {
        $userId = $request->user_id; // Get the authenticated user's ID

        $feed = Tweet::with(['user' => function ($query) {
            $query->select('id', 'full_name', 'username', 'profile_picture');
        }])
            ->select('id', 'user_id', 'body', 'created_at') // Select only required columns from the tweets table
            ->where('id', $userId)
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc');

        foreach ($feed as $item) {
            $item->duration = $this->ModifyDate($item->created_at);
        }

        return $feed;
    }
}
