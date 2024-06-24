<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up (): void {
    Schema::create('likes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->foreignId('tweet_id')->nullable();
      $table->foreignId('comment_id')->nullable();
      $table->timestamp('created_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down (): void {
    Schema::dropIfExists('likes');
  }
};
