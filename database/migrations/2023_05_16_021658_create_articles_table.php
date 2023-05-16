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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250)->nullable();
            $table->string('banner', 500)->nullable();
            $table->string('description', 500)->nullable();
            $table->longText('content')->nullable();
            $table->string('source', 250)->nullable();
            $table->string('url', 500)->nullable();
            $table->string('category', 250)->nullable();
            $table->string('author', 250)->nullable();
            $table->timestamp('publishedAt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
