<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
  public function definition (): array {
    return [
      'full_name'         => $this->generateShortName(),
      'username'          => fake()->unique()->userName(),
      'email'             => fake()->unique()->safeEmail(),
      'profile_picture'   => "https://picsum.photos/id/" . random_int(1, 100) . "/400",
      'cover_photo'       => "https://picsum.photos/id/" . random_int(1, 100) . "/640/220",
      'email_verified_at' => now(),
      'password'          => static::$password ??= Hash::make('password'),
      'remember_token'    => Str::random(10),
    ];
  }

  protected function generateShortName (): string {
    $faker = $this->faker;
    do {
      $fullName = $faker->name();
    } while (strlen($fullName) > 20);

    return $fullName;
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified (): static {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
