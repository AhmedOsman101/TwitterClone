<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('followers', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(User::class, 'followerId')
        ->comment("the user who follows");
      $table->foreignIdFor(User::class, 'followedUserId')
        ->comment("the user being followed");
      $table->uuid('notificationId')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('followers');
  }
};
