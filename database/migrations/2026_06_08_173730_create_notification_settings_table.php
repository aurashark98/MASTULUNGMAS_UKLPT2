<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('notification_settings')) {
            Schema::create('notification_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('type'); // e.g., 'new_bid', 'task_completed', etc.
                $table->boolean('email_enabled')->default(true);
                $table->boolean('database_enabled')->default(true);
                $table->timestamps();

                $table->unique(['user_id', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
