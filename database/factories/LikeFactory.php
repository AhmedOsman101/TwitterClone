<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory {
  protected $model = Like::class;

  public function definition () {
    // Randomly decide whether to like a tweet or a comment
    $likeableType = $this->faker->randomElement(['tweet', 'comment']);

    // Generate user_id and either tweet_id or comment_id
    if ($likeableType === 'tweet') {
      return [
        'user_id'    => User::inRandomOrder()->first()->id,
        'tweet_id'   => Tweet::inRandomOrder()->first()->id,
        'comment_id' => null,
      ];
    }

    return [
      'user_id'    => User::inRandomOrder()->first()->id,
      'tweet_id'   => null,
      'comment_id' => Comment::inRandomOrder()->first()->id,
    ];
  }
}
