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
    Schema::create('notifications', function (Blueprint $table) {
      $table->uuid('id')->primary();

      $table->string('type');

      $table->morphs('notifiable');

      $table->unsignedBigInteger('userId')
        ->nullable()
        ->comment('the user who triggered the notification');

      $table->text('data');

      $table->timestamp('readAt')->nullable();

      $table->timestamp('createdAt')->useCurrent();
      $table->timestamp('updatedAt')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('notifications');
  }
};
