<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Like;
use App\Models\Tweet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   */
  public function run(): void {
    $this->call(UserSeeder::class);

    Tweet::factory(10)->create();

    Comment::factory(10)->create();

    Like::factory(10)->create();

    Follower::factory(40)->create();
  }
}
