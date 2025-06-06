<?php

namespace Database\Factories;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'userId'  => User::inRandomOrder()->first()->id,
      'tweetId' => Tweet::inRandomOrder()->first()->id,
      'body'    => $this->faker->paragraph(),
    ];
  }
}
