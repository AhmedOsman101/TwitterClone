<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   */
  public function run (): void {
    User::factory(10)->create();
    Tweet::factory(10)->create();
    Comment::factory(10)->create();
    Like::factory(10)->create();


  }
}
