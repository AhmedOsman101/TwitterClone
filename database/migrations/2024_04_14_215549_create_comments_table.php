<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up (): void {
    Schema::create('comments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');  // the user who made the comment
      $table->foreignId('tweet_id'); // the tweet the comment belongs to
      $table->unsignedInteger('likes_count')->default(0);
      $table->string('body', 255);
      $table->timestamp('created_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down (): void {
    Schema::dropIfExists('comments');
  }
};
