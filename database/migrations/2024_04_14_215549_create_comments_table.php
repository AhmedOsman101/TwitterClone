<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('comments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('userId');  // the user who made the comment
      $table->foreignId('tweetId'); // the tweet the comment belongs to
      $table->string('body', 255);
      $table->uuid('notificationId')->nullable()
        ->comment("UUID of the notification related to this comment action");
      $table->timestamp('created_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('comments');
  }
};
