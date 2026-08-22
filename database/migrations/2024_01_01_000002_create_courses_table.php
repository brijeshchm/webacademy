<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category_slug');
            $table->string('category_name');
            $table->string('level');
            $table->text('summary');
            $table->longText('description');
            $table->integer('duration_hours');
            $table->string('mode');
            $table->integer('price');
            $table->float('rating')->default(4.7);
            $table->integer('total_rating')->default(0);
            $table->integer('enrolled')->default(0);
            $table->boolean('featured')->default(false);
            $table->json('skills')->nullable();
            $table->string('image_url')->default('');
            $table->json('curriculum')->nullable();
            $table->json('faq')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
