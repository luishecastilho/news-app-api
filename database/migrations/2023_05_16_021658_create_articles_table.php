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
            $table->string('title', 250);
            $table->string('banner', 500);
            $table->string('description', 500);
            $table->longText('content');
            $table->string('source', 250);
            $table->string('url', 500);
            $table->string('category', 250);
            $table->string('author', 250);
            $table->date('publishedAt');
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
