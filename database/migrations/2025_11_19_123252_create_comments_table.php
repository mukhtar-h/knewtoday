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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // Post this comment belongs to
            $table->foreignId('post_id')
                ->constrained()
                ->cascadeOnDelete();

            // Parent comment for nested replies
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('comments')
                ->cascadeOnDelete();

            // If user is logged in, store user_id
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Guest fields
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();

            // Main content
            $table->text('body');

            // Status: pending, approved, spam, hidden
            $table->string('status')->default('approve');

            // For sorting & reporting
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
