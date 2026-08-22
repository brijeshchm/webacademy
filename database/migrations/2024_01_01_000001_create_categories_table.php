<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline');
            $table->text('description');
            $table->string('icon_key');
            $table->integer('course_count')->default(0);
            $table->float('rating')->default(4.8);
            $table->integer('learners_enrolled')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
