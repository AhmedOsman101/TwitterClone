<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    // my root user
    User::create([
      'fullName' => 'Othman',
      'username' => 'othman',
      'email'    => 'othman@mail.com',
      'password' => Hash::make('123'),
    ]);

    // random users
    User::factory(10)->create();
  }
}
