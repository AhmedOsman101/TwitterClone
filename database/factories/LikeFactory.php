<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory {
  protected $model = Like::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    // Randomly decide whether to like a tweet or a comment
    $likeableType = array_rand(['tweet', 'comment']);

    // Generate userId and either tweetId or commentId
    if ($likeableType === 0) { // 0 for tweet, 1 for comment
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
