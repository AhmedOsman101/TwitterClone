<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory {
  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {

    $profile_picture = "https://picsum.photos/id/" . random_int(1, 95) . "/400";
    $cover_photo     = "https://picsum.photos/id/" . random_int(1, 95) . "/640/220";

    return [
      'full_name'         => Str::limit(fake()->name(), 50),
      'username'          => fake()->unique()->userName(),
      'email'             => fake()->unique()->safeEmail(),
      'bio'               => $this->faker->bs(),
      'profile_picture'   => $this->faker->randomElement([$profile_picture, null]),
      'cover_photo'       => $this->faker->randomElement([$cover_photo, null]),
      'email_verified_at' => now(),
      'password'          => static::$password ??= Hash::make('123'),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified(): static {
    return $this->state(fn (array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
