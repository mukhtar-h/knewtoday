<?php

use App\Enums\PostStatus;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Author
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Category
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Main content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // for cards / meta fallback
            $table->longText('content');

            // Status & flags
            $table->string('status')
                ->default(PostStatus::Draft->value);
            $table->boolean('is_featured')->default(false);

            // Media
            $table->string('thumbnail_path')->nullable(); // local path or url


            // Publishing
            $table->unsignedSmallInteger('reading_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
