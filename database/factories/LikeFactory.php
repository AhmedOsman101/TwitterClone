<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory {
  protected $model = Like::class;

  public function definition() {
    // Randomly decide whether to like a tweet or a comment
    $likeableType = $this->faker->randomElement([ 'tweet', 'comment' ]);

    // Generate userId and either tweetId or commentId
    if ($likeableType === 'tweet') {
      return [
        'userId'    => User::inRandomOrder()->first()->id,
        'tweetId'   => Tweet::inRandomOrder()->first()->id,
        'commentId' => null,
      ];
    }

    return [
      'userId'    => User::inRandomOrder()->first()->id,
      'tweetId'   => null,
      'commentId' => Comment::inRandomOrder()->first()->id,
    ];
  }
}
