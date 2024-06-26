<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up (): void {
    Schema::create('tweets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->string('body', 300);
      $table->timestamp('created_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down (): void {
    Schema::dropIfExists('tweets');
  }
};
